<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Winners_model extends CI_Model
{
    public function insert_winner($data)
    {
        return $this->db->insert('winners', $data);
    }

    public function update_winner($id, $data)
    {
        return $this->db->update('winners', $data, array('id' => (int) $id));
    }

    public function delete_winner($id)
    {
        return $this->db->delete('winners', array('id' => (int) $id));
    }

    public function get_winners_by_event($event_id)
    {
        $event_id = (int) $event_id;
        if ($event_id <= 0) {
            return array();
        }

        $this->db->select("
            id,
            event_id,
            event_name,
            event_group,
            category,
            first_name,
            middle_name,
            last_name,
            CASE
                WHEN TRIM(IFNULL(last_name, '')) = '' THEN TRIM(CONCAT_WS(' ', first_name, middle_name))
                ELSE TRIM(CONCAT_WS(' ', CONCAT(last_name, ','), first_name, middle_name))
            END AS full_name,
            medal,
            municipality,
            school,
            coach,
            created_at
        ", false);
        $this->db->from('winners');
        $this->db->where('event_id', $event_id);
        $this->db->order_by("FIELD(medal, 'Gold', 'Silver', 'Bronze')", '', false);
        $this->db->order_by('full_name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_winner($id)
    {
        return $this->db
            ->get_where('winners', array('id' => (int) $id))
            ->row();
    }

    public function get_winners_list($event_group = null, $municipality = null)
    {
        // Build a medal tally subquery so we can rank rows by municipality performance first
        $tallyBuilder = $this->db->select("
            municipality,
            SUM(medal = 'Gold')   AS gold_count,
            SUM(medal = 'Silver') AS silver_count,
            SUM(medal = 'Bronze') AS bronze_count,
            COUNT(*)              AS total_medals
        ", FALSE)->from('winners');

        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $tallyBuilder->where('event_group', $event_group);
        }
        if (!empty($municipality)) {
            $tallyBuilder->where('municipality', $municipality);
        }

        $tallyBuilder->group_by('municipality');
        $medalTallySql = $tallyBuilder->get_compiled_select();

        $this->db->select("
            w.event_name,
            w.event_group,
            w.category,
            CASE
                WHEN TRIM(IFNULL(w.last_name, '')) = '' THEN TRIM(CONCAT_WS(' ', w.first_name, w.middle_name))
                ELSE TRIM(CONCAT_WS(' ', CONCAT(w.last_name, ','), w.first_name, w.middle_name))
            END AS full_name,
            w.medal,
            w.municipality,
            w.school,
            w.coach,
            w.created_at,
            m.gold_count,
            m.silver_count,
            m.bronze_count,
            m.total_medals
        ", FALSE);
        $this->db->from('winners w');
        $this->db->join("({$medalTallySql}) m", 'm.municipality = w.municipality', 'left');

        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $this->db->where('w.event_group', $event_group);
        }
        if (!empty($municipality)) {
            $this->db->where('w.municipality', $municipality);
        }

        // Order: municipality medal tally, then medal, then event/group/category/name
        $this->db->order_by('m.gold_count', 'DESC');
        $this->db->order_by('m.silver_count', 'DESC');
        $this->db->order_by('m.bronze_count', 'DESC');
        $this->db->order_by('m.total_medals', 'DESC');
        $this->db->order_by("FIELD(w.medal, 'Gold', 'Silver', 'Bronze')", '', FALSE);
        $this->db->order_by('w.event_name', 'ASC');
        $this->db->order_by('w.event_group', 'ASC');
        $this->db->order_by('w.category', 'ASC');
        $this->db->order_by('full_name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_recent_winners($limit = 10)
    {
        $this->db->select("
            id,
            event_id,
            event_name,
            event_group,
            category,
            first_name,
            middle_name,
            last_name,
            CASE
                WHEN TRIM(IFNULL(last_name, '')) = '' THEN TRIM(CONCAT_WS(' ', first_name, middle_name))
                ELSE TRIM(CONCAT_WS(' ', CONCAT(last_name, ','), first_name, middle_name))
            END AS full_name,
            medal,
            municipality,
            school,
            coach,
            created_at
        ", FALSE);
        $this->db->from('winners');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    // Medal tally by municipality (all groups)
    public function get_medal_tally()
    {
        $this->db->select("
            municipality,
            SUM(medal = 'Gold')   AS gold,
            SUM(medal = 'Silver') AS silver,
            SUM(medal = 'Bronze') AS bronze,
            COUNT(*)              AS total_medals
        ", FALSE);
        $this->db->from('winners');
        $this->db->group_by('municipality');
        $this->db->order_by('gold', 'DESC');
        $this->db->order_by('silver', 'DESC');
        $this->db->order_by('bronze', 'DESC');
        $this->db->order_by('municipality', 'ASC');

        return $this->db->get()->result();
    }

    // Medal tally by municipality + group (Elementary / Secondary)
    public function get_medal_tally_by_group($event_group)
    {
        $this->db->select("
            municipality,
            event_group,
            SUM(medal = 'Gold')   AS gold,
            SUM(medal = 'Silver') AS silver,
            SUM(medal = 'Bronze') AS bronze,
            COUNT(*)              AS total_medals
        ", FALSE);
        $this->db->from('winners');
        $this->db->where('event_group', $event_group);
        $this->db->group_by(array('municipality', 'event_group'));
        $this->db->order_by('gold', 'DESC');
        $this->db->order_by('silver', 'DESC');
        $this->db->order_by('bronze', 'DESC');
        $this->db->order_by('municipality', 'ASC');

        return $this->db->get()->result();
    }

    // NEW: overview stats for the header cards
    public function get_overview($event_group = null, $municipality = null)
    {
        $this->db->select("
            COUNT(DISTINCT municipality)         AS municipalities,
            COUNT(DISTINCT event_name)           AS events,
            SUM(medal = 'Gold')                  AS gold,
            SUM(medal = 'Silver')                AS silver,
            SUM(medal = 'Bronze')                AS bronze,
            COUNT(*)                             AS total_medals,
            MAX(created_at)                      AS last_update
        ", FALSE);
        $this->db->from('winners');

        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $this->db->where('event_group', $event_group);
        }
        if (!empty($municipality)) {
            $this->db->where('municipality', $municipality);
        }

        return $this->db->get()->row();
    }
}
