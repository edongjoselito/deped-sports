<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provincial extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Winners_model');
        $this->load->model('Events_model');
        $this->load->model('Address_model');
        $this->load->model('MeetSettings_model'); // NEW
        $this->load->model('Technical_model'); // NEW
        $this->load->library(array('form_validation', 'session'));
        $this->load->helper(array('url', 'form'));
    }

    public function index()
    {
        $group = $this->input->get('group', TRUE);
        $municipality = $this->input->get('municipality', TRUE);

        $isGrouped = ($group === 'Elementary' || $group === 'Secondary');

        $winners  = $this->Winners_model->get_winners_list($isGrouped ? $group : null, $municipality);
        $overview = $this->Winners_model->get_overview($isGrouped ? $group : null, $municipality);
        $active   = $isGrouped ? $group : 'ALL';
        $tally    = $isGrouped
            ? $this->Winners_model->get_medal_tally_by_group($group)
            : $this->Winners_model->get_medal_tally();

        $data = array(
            'active_group' => $active,
            'active_municipality' => $municipality,
            'winners'      => $winners,
            'overview'     => $overview,
            'events_list'  => $this->Events_model->get_events_with_meta_and_counts(),
            'municipality_tally' => $tally,
            'municipalities_all' => $this->Address_model->get_municipalities(),
            'meet'         => $this->MeetSettings_model->get_settings(), // NEW
        );

        // Map municipality => logo for quick lookup in views
        $logoMap = array();
        if (!empty($data['municipalities_all'])) {
            foreach ($data['municipalities_all'] as $m) {
                $name = isset($m->municipality) ? $m->municipality : '';
                if ($name !== '') {
                    $logoMap[$name] = isset($m->logo) ? $m->logo : '';
                }
            }
        }
        $data['municipality_logos'] = $logoMap;

        $this->load->view('provincial_landing', $data);
    }

    // Optional alias
    public function standings()
    {
        $this->index();
    }

    public function admin()
    {
        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
            $rawRows = $this->input->post('winners', TRUE);
            list($winnerRows, $rowErrors, $skippedRows) = $this->normalize_winner_rows($rawRows, false);

            if ($this->form_validation->run()) {
                if (!empty($rowErrors)) {
                    $this->session->set_flashdata('error', implode('<br>', $rowErrors));
                    redirect('provincial/admin');
                    return;
                }

                if (empty($winnerRows)) {
                    $this->session->set_flashdata('error', 'Please add at least one winner.');
                    redirect('provincial/admin');
                    return;
                }

                $eventId = (int) $this->input->post('event_id', TRUE);
                $event   = $this->Events_model->get_event_details($eventId);

                if (!$event) {
                    $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                    redirect('provincial/admin');
                    return;
                }

                foreach ($winnerRows as $row) {
                    $groupId = (int) $this->input->post('group_id', TRUE);
                    $categoryId = (int) $this->input->post('category_id', TRUE);
                    $groupName = $event->group_name ?? 'Unspecified';
                    $categoryName = $event->category_name;

                    if ($groupId > 0) {
                        $groupRow = $this->Events_model->get_group($groupId);
                        if ($groupRow && !empty($groupRow->group_name)) {
                            $groupName = $groupRow->group_name;
                        }
                    }

                    if ($categoryId > 0) {
                        $categoryRow = $this->Events_model->get_category((int) $categoryId);
                        if ($categoryRow && !empty($categoryRow->category_name)) {
                            $categoryName = $categoryRow->category_name;
                        }
                    }

                    $insert = array(
                        'event_id'    => $event->event_id,
                        'event_name'  => $event->event_name,
                        'event_group' => $groupName,
                        'category'    => $categoryName,
                        'first_name'  => $row['first_name'],
                        'middle_name' => $row['middle_name'],
                        'last_name'   => $row['last_name'],
                        'medal'       => $row['medal'],
                        'municipality' => $row['municipality'],
                        'school'      => $row['school'],
                        'coach'       => $row['coach'],
                    );

                    $this->Winners_model->insert_winner($insert);
                }

                $count = count($winnerRows);
                $message = $count > 1
                    ? $count . ' winners saved successfully.'
                    : 'Winner saved successfully.';
                if (!empty($skippedRows)) {
                    $message .= ' (Skipped ' . $skippedRows . ' incomplete row' . ($skippedRows > 1 ? 's' : '') . '.)';
                }
                $this->session->set_flashdata('success', $message);
                redirect('provincial/admin');
                return;
            }
        }

        // pass meet settings to the admin form
        $data['meet'] = $this->MeetSettings_model->get_settings();
        // Show a larger slice so bulk entries aren't hidden
        $data['recent_winners'] = $this->Winners_model->get_recent_winners(200);
        $data['event_categories'] = $this->Events_model->get_categories();
        $data['event_groups'] = $this->Events_model->get_groups();
        $data['events'] = $this->Events_model->get_events_with_meta_and_counts();
        $data['municipalities'] = $this->Address_model->get_municipalities();
        $data['technical'] = $this->Technical_model->get_all();

        $this->load->view('dashboard_admin', $data);
    }

    /**
     * Technical officials manager.
     */
    public function technical()
    {
        $this->require_login();
        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['technical'] = $this->Technical_model->get_all();
        $data['events'] = $this->Events_model->get_events_with_meta_and_counts();
        $data['event_groups'] = $this->Events_model->get_groups();
        $data['event_categories'] = $this->Events_model->get_categories();
        $this->load->view('technical_admin', $data);
    }

    public function report()
    {
        $this->require_login();
        $selectedId = (int) $this->input->get('event_id', TRUE);
        $events = $this->Events_model->get_events_with_meta_and_counts();
        $selectedEvent = null;
        foreach ($events as $ev) {
            if ((int)$ev->event_id === $selectedId) {
                $selectedEvent = $ev;
                break;
            }
        }

        $winners = array();
        $technical = array();
        if ($selectedEvent) {
            $winners = $this->Winners_model->get_winners_by_event($selectedId);
            $technical = $this->Technical_model->get_by_event($selectedId);
        }

        $data = array(
            'meet' => $this->MeetSettings_model->get_settings(),
            'events' => $events,
            'selected_event' => $selectedEvent,
            'winners' => $winners,
            'technical' => $technical,
            'selected_id' => $selectedId,
        );

        $this->load->view('report_event', $data);
    }

    public function add_technical()
    {
        $this->require_login();
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $eventId = (int) $this->input->post('event_id', TRUE);
            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event not found.');
                redirect('provincial/technical');
                return;
            }

            $names = $this->input->post('names');
            $roles = $this->input->post('roles');
            $groupInput = trim((string) $this->input->post('event_group', TRUE));
            $categoryInput = trim((string) $this->input->post('event_category', TRUE));
            $groupLabel = $groupInput !== '' ? $groupInput : ($event->group_name ?? '');
            $categoryLabel = $categoryInput !== '' ? $categoryInput : ($event->category_name ?? '');
            $saved = 0;
            if (is_array($names) && is_array($roles)) {
                foreach ($names as $idx => $name) {
                    $name = trim((string) $name);
                    $role = isset($roles[$idx]) ? $roles[$idx] : 'Technical Official';
                    if ($name === '') {
                        continue;
                    }
                    $this->Technical_model->create(
                        $name,
                        $role,
                        $eventId,
                        $event->event_name ?? '',
                        $groupLabel,
                        $categoryLabel
                    );
                    $saved++;
                }
            }

            if ($saved > 0) {
                $this->session->set_flashdata('success', $saved . ' entr' . ($saved > 1 ? 'ies' : 'y') . ' added.');
            } else {
                $this->session->set_flashdata('error', 'Please add at least one name.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/technical');
    }

    public function update_technical()
    {
        $this->require_login();
        $this->form_validation->set_rules('id', 'ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[Tournament Manager,Technical Official]');
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_group', 'Group', 'trim');
        $this->form_validation->set_rules('event_category', 'Category', 'trim');

        if ($this->form_validation->run()) {
            $id = (int) $this->input->post('id', TRUE);
            $existing = $this->Technical_model->get($id);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Entry not found.');
                redirect('provincial/technical');
                return;
            }

            $eventId = (int) $this->input->post('event_id', TRUE);
            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event not found.');
                redirect('provincial/technical');
                return;
            }

            $groupInput = trim((string) $this->input->post('event_group', TRUE));
            $categoryInput = trim((string) $this->input->post('event_category', TRUE));
            $groupLabel = $groupInput !== '' ? $groupInput : ($event->group_name ?? '');
            $categoryLabel = $categoryInput !== '' ? $categoryInput : ($event->category_name ?? '');

            $this->Technical_model->update(
                $id,
                $this->input->post('name', TRUE),
                $this->input->post('role', TRUE),
                $eventId,
                $event->event_name ?? '',
                $groupLabel,
                $categoryLabel
            );
            $this->session->set_flashdata('success', 'Entry updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/technical');
    }

    public function delete_technical()
    {
        $this->require_login();
        $this->form_validation->set_rules('id', 'ID', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $id = (int) $this->input->post('id', TRUE);
            $existing = $this->Technical_model->get($id);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Entry not found.');
            } else {
                $this->Technical_model->delete($id);
                $this->session->set_flashdata('success', 'Entry deleted.');
            }
        }

        redirect('provincial/technical');
    }

    /**
     * Municipality manager – city-only CRUD.
     */
    public function municipalities()
    {
        $this->require_login();

        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['municipalities'] = $this->Address_model->get_municipalities();

        $this->load->view('municipalities_admin', $data);
    }

    public function add_municipality()
    {
        $this->require_login();
        $this->form_validation->set_rules('city', 'Municipality/City', 'required|trim');

        if ($this->form_validation->run()) {
            $city = trim($this->input->post('city', TRUE));

            if ($this->Address_model->city_exists($city)) {
                $this->session->set_flashdata('error', 'Municipality already exists.');
            } else {
                $upload = $this->handle_logo_upload('logo');
                if ($upload['error']) {
                    $this->session->set_flashdata('error', $upload['message']);
                    redirect('provincial/teams');
                    return;
                }

                $this->Address_model->add_city($city);
                if ($upload['file']) {
                    $this->Address_model->set_logo($city, $upload['file']);
                }
                $this->session->set_flashdata('success', 'Municipality added.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/teams');
    }

    public function update_municipality()
    {
        $this->require_login();
        $this->form_validation->set_rules('current_city', 'Current Municipality', 'required|trim');
        $this->form_validation->set_rules('city', 'Municipality/City', 'required|trim');

        if ($this->form_validation->run()) {
            $current = trim($this->input->post('current_city', TRUE));
            $city    = trim($this->input->post('city', TRUE));

            if (!$this->Address_model->city_exists($current)) {
                $this->session->set_flashdata('error', 'Municipality not found.');
                redirect('provincial/teams');
                return;
            }

            if ($this->Address_model->city_exists($city) && strcasecmp($current, $city) !== 0) {
                $this->session->set_flashdata('error', 'Another entry already uses that municipality.');
                redirect('provincial/teams');
                return;
            }

            $upload = $this->handle_logo_upload('logo');
            if ($upload['error']) {
                $this->session->set_flashdata('error', $upload['message']);
                redirect('provincial/teams');
                return;
            }

            // If name unchanged and no logo uploaded, nothing to do
            if ($current === $city && empty($upload['file'])) {
                $this->session->set_flashdata('success', 'No changes to save.');
                redirect('provincial/teams');
                return;
            }

            $this->Address_model->update_city($current, $city, $upload['file']);
            $this->session->set_flashdata('success', 'Teams updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/teams');
    }

    public function delete_municipality()
    {
        $this->require_login();
        $this->form_validation->set_rules('city', 'Municipality/City', 'required|trim');

        if ($this->form_validation->run()) {
            $city = trim($this->input->post('city', TRUE));

            if (!$this->Address_model->city_exists($city)) {
                $this->session->set_flashdata('error', 'Municipality not found.');
            } else {
                $this->Address_model->delete_city($city);
                $this->session->set_flashdata('success', 'Municipality deleted.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/teams');
    }

    public function update_winner()
    {
        $this->form_validation->set_rules('winner_id', 'Winner ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
        $rawRows = $this->input->post('winners', TRUE);

        // Backward compatibility if the request comes from the old single-entry form
        if (!is_array($rawRows)) {
            $rawRows = array(array(
                'first_name'   => $this->input->post('first_name', TRUE),
                'middle_name'  => $this->input->post('middle_name', TRUE),
                'last_name'    => $this->input->post('last_name', TRUE),
                'medal'        => $this->input->post('medal', TRUE),
                'municipality' => $this->input->post('municipality', TRUE),
                'school'       => $this->input->post('school', TRUE),
                'coach'        => $this->input->post('coach', TRUE),
                'group_id'     => $this->input->post('group_id', TRUE),
                'category_id'  => $this->input->post('category_id', TRUE),
            ));
        }

        list($winnerRows, $rowErrors) = $this->normalize_winner_rows($rawRows, true);

        if ($this->form_validation->run()) {
            if (!empty($rowErrors)) {
                $this->session->set_flashdata('error', implode('<br>', $rowErrors));
                redirect('provincial/admin');
                return;
            }

            if (empty($winnerRows)) {
                $this->session->set_flashdata('error', 'Please enter the winner details to update.');
                redirect('provincial/admin');
                return;
            }

            if (count($winnerRows) > 1) {
                $this->session->set_flashdata('error', 'Please edit one winner at a time.');
                redirect('provincial/admin');
                return;
            }

            $winnerId = (int) $this->input->post('winner_id', TRUE);
            $eventId  = (int) $this->input->post('event_id', TRUE);

            $winner = $this->Winners_model->get_winner($winnerId);
            if (!$winner) {
                $this->session->set_flashdata('error', 'Winner not found.');
                redirect('provincial/admin');
                return;
            }

            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                redirect('provincial/admin');
                return;
            }

            $groupId = (int) $this->input->post('group_id', TRUE);
            $categoryId = (int) $this->input->post('category_id', TRUE);
            $groupName = $event->group_name ?? 'Unspecified';
            $categoryName = $event->category_name;

            if ($groupId > 0) {
                $groupRow = $this->Events_model->get_group($groupId);
                if ($groupRow && !empty($groupRow->group_name)) {
                    $groupName = $groupRow->group_name;
                }
            }

            if ($categoryId > 0) {
                $categoryRow = $this->Events_model->get_category((int) $categoryId);
                if ($categoryRow && !empty($categoryRow->category_name)) {
                    $categoryName = $categoryRow->category_name;
                }
            }

            $payload = $winnerRows[0];
            $update = array(
                'event_id'    => $event->event_id,
                'event_name'  => $event->event_name,
                'event_group' => $groupName,
                'category'    => $categoryName,
                'first_name'   => $payload['first_name'],
                'middle_name'  => $payload['middle_name'],
                'last_name'    => $payload['last_name'],
                'medal'        => $payload['medal'],
                'municipality' => $payload['municipality'],
                'school'       => $payload['school'],
                'coach'        => $payload['coach'],
            );

            $this->Winners_model->update_winner($winnerId, $update);
            $this->session->set_flashdata('success', 'Winner updated successfully.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    public function delete_winner($winner_id = null)
    {
        $id = (int) $winner_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid winner.');
            redirect('provincial/admin');
            return;
        }

        $existing = $this->Winners_model->get_winner($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Winner not found.');
            redirect('provincial/admin');
            return;
        }

        $this->Winners_model->delete_winner($id);
        $this->session->set_flashdata('success', 'Winner deleted.');
        redirect('provincial/admin');
    }

    // CRUD: create category
    public function add_category()
    {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');

        if ($this->form_validation->run()) {
            $name = $this->input->post('category_name', TRUE);
            $this->Events_model->create_category($name);
            $this->session->set_flashdata('success', 'Category added.');
        } else {
            $this->session->set_flashdata('category_error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: update category
    public function update_category()
    {
        $this->form_validation->set_rules('category_id', 'Category ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');

        if ($this->form_validation->run()) {
            $id   = (int) $this->input->post('category_id', TRUE);
            $name = $this->input->post('category_name', TRUE);

            $existing = $this->Events_model->get_category($id);
            if (!$existing) {
                $this->session->set_flashdata('category_error', 'Category not found.');
                redirect('provincial/admin');
                return;
            }

            $this->Events_model->update_category($id, $name);
            $this->session->set_flashdata('success', 'Category updated.');
        } else {
            $this->session->set_flashdata('category_error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: delete category
    public function delete_category($category_id = null)
    {
        $id = (int) $category_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid category.');
            redirect('provincial/admin');
            return;
        }

        $existing = $this->Events_model->get_category($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Category not found.');
            redirect('provincial/admin');
            return;
        }

        $this->Events_model->delete_category($id);
        $this->session->set_flashdata('success', 'Category deleted.');
        redirect('provincial/admin');
    }

    // CRUD: create event
    public function add_event()
    {
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim');
        $this->form_validation->set_rules('group_id', 'Group', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('category_name', 'Category', 'trim');

        if ($this->form_validation->run()) {
            $name       = $this->input->post('event_name', TRUE);
            $groupId    = (int) $this->input->post('group_id', TRUE);
            $categoryName = $this->input->post('category_name', TRUE);
            $categoryId = $categoryName !== '' ? $this->Events_model->ensure_category($categoryName) : null;

            $this->Events_model->create_event($name, $groupId, $categoryId);
            $this->session->set_flashdata('success', 'Event added.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: update event
    public function update_event()
    {
        $this->form_validation->set_rules('event_id', 'Event ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim');
        $this->form_validation->set_rules('group_id', 'Group', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('category_name', 'Category', 'trim');

        if ($this->form_validation->run()) {
            $eventId    = (int) $this->input->post('event_id', TRUE);
            $name       = $this->input->post('event_name', TRUE);
            $groupId    = (int) $this->input->post('group_id', TRUE);
            $categoryName = $this->input->post('category_name', TRUE);
            $categoryId = $categoryName !== '' ? $this->Events_model->ensure_category($categoryName) : null;

            $existing = $this->Events_model->get_event_details($eventId);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Event not found.');
                redirect('provincial/admin');
                return;
            }

            $this->Events_model->update_event($eventId, $name, $groupId, $categoryId);
            $this->session->set_flashdata('success', 'Event updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: delete event
    public function delete_event($event_id = null)
    {
        $id = (int) $event_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid event.');
            redirect('provincial/admin');
            return;
        }

        $existing = $this->Events_model->get_event_details($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('provincial/admin');
            return;
        }

        $this->Events_model->delete_event($id);
        $this->session->set_flashdata('success', 'Event deleted.');
        redirect('provincial/admin');
    }

    /**
     * Normalize the posted winners payload: skip empty rows and surface per-row errors.
     *
     * @param array|null $rawRows
     * @return array [$validRows, $errors]
     */
    private function normalize_winner_rows($rawRows, $strictMissing = false)
    {
        $validRows = array();
        $errors    = array();
        $allowed   = array('Gold', 'Silver', 'Bronze');
        $medalCounts = array('Gold' => 0, 'Silver' => 0, 'Bronze' => 0);
        $skippedMissing = 0;

        if (!is_array($rawRows)) {
            return array($validRows, $errors, $skippedMissing);
        }

        foreach ($rawRows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $first = isset($row['first_name']) ? trim($row['first_name']) : '';
            $middle = isset($row['middle_name']) ? trim($row['middle_name']) : '';
            $last = isset($row['last_name']) ? trim($row['last_name']) : '';
            $entryType = strtolower(isset($row['entry_type']) ? trim($row['entry_type']) : 'individual');
            $teamNames = isset($row['team_names']) ? trim($row['team_names']) : '';
            $municipality = isset($row['municipality']) ? trim($row['municipality']) : '';
            $school = isset($row['school']) ? trim($row['school']) : '';
            $coach = isset($row['coach']) ? trim($row['coach']) : '';
            $medal = isset($row['medal']) ? trim($row['medal']) : '';

            $allEmpty = ($first === '' && $middle === '' && $last === '' && $municipality === '' && $teamNames === '');
            if ($allEmpty) {
                continue;
            }

            $labelMedal = in_array($medal, $allowed, true) ? $medal : 'Entry';
            $medalCounts[$labelMedal] = isset($medalCounts[$labelMedal]) ? $medalCounts[$labelMedal] + 1 : 1;
            $label = ($labelMedal !== 'Entry')
                ? $labelMedal . ' entry #' . $medalCounts[$labelMedal]
                : 'Entry #' . ($index + 1);

            if (!in_array($medal, $allowed, true)) {
                $errors[] = $label . ' needs a valid medal (Gold, Silver, or Bronze).';
                continue;
            }

            if ($entryType === 'team') {
                if ($teamNames === '' || $municipality === '') {
                    if ($strictMissing) {
                        $errors[] = $label . ' is missing team names or municipality.';
                    } else {
                        $skippedMissing++;
                    }
                    continue;
                }
                // Map team entry into first_name for storage; leave middle/last blank
                $first = $teamNames;
                $middle = '';
                $last = '';
            } else {
                if ($first === '' || $last === '' || $municipality === '') {
                    if ($strictMissing) {
                        $errors[] = $label . ' is missing first name, last name, or municipality.';
                    } else {
                        $skippedMissing++;
                    }
                    continue;
                }
            }

            $validRows[] = array(
                'first_name'   => $first,
                'middle_name'  => $middle,
                'last_name'    => $last,
                'medal'        => $medal,
                'municipality' => $municipality,
                'school'       => $school,
                'coach'        => $coach,
                'entry_type'   => ($entryType === 'team') ? 'team' : 'individual',
                'team_names'   => $teamNames,
            );
        }

        return array($validRows, $errors, $skippedMissing);
    }

    // NEW: update meet title/year/subtitle from admin
    public function update_meet_settings()
    {
        $this->form_validation->set_rules('meet_title', 'Meet Title', 'required|trim');
        $this->form_validation->set_rules('meet_year', 'Meet Year', 'required|trim');

        if ($this->form_validation->run()) {
            $data = array(
                'meet_title' => $this->input->post('meet_title', TRUE),
                'meet_year'  => $this->input->post('meet_year', TRUE),
                'subtitle'   => $this->input->post('subtitle', TRUE),
            );

            $this->MeetSettings_model->update_settings($data);
            $this->session->set_flashdata('success', 'Meet header updated.');
        }

        redirect('provincial/admin');
    }

    /**
     * Require an authenticated session before accessing admin endpoints.
     */
    private function require_login()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please log in to continue.');
            redirect('login');
            exit;
        }
    }

    /**
     * Handle optional team logo upload; returns ['error'=>bool,'message'=>string,'file'=>string|null]
     */
    private function handle_logo_upload($field)
    {
        if (empty($_FILES[$field]['name'])) {
            return array('error' => false, 'message' => '', 'file' => null);
        }

        $config = array(
            'upload_path'   => FCPATH . 'upload/team_logos',
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => 2048,
        );

        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0775, true);
        }

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($field)) {
            return array('error' => true, 'message' => $this->upload->display_errors('', ''), 'file' => null);
        }

        $data = $this->upload->data();
        return array('error' => false, 'message' => '', 'file' => $data['file_name']);
    }
}
