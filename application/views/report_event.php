<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    body {
        font-family: 'Times New Roman', serif;
        background: #f3f4f6;
        padding: 20px;
    }
    .report-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        max-width: 900px;
        margin: 0 auto;
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }
    .report-header {
        text-align: center;
        margin-bottom: 16px;
    }
    .report-header img {
        height: 70px;
        margin-bottom: 8px;
    }
    .report-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }
    .report-header h4 {
        margin: 4px 0;
        font-size: 20px;
        font-weight: 800;
        text-transform: uppercase;
    }
    .report-header .meta {
        font-size: 13px;
        color: #374151;
        margin-top: 4px;
    }
    .event-title {
        font-size: 16px;
        font-weight: 700;
        margin: 18px 0 8px;
        text-align: center;
    }
    .table-report {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }
    .table-report th,
    .table-report td {
        border: 1px solid #111827;
        padding: 8px 10px;
        font-size: 13px;
    }
    .table-report th {
        background: #f9fafb;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .sign-row {
        display: flex;
        justify-content: space-between;
        margin-top: 28px;
        font-size: 14px;
    }
    .sign-slot {
        width: 48%;
        border-top: 1px solid #111827;
        padding-top: 6px;
        text-align: center;
        font-weight: 600;
    }
    .filter-form {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }
    .filter-form select {
        min-width: 260px;
    }
    .btn-print {
        margin-left: auto;
    }
    @media print {
        body { background: #ffffff; }
        .report-card { box-shadow: none; border: none; margin: 0; }
        .filter-form, .btn-print, .btn-back { display: none !important; }
    }
</style>
<body>
    <?php include('includes/top-nav-bar.php'); ?>
    <div class="container-fluid">
        <div class="filter-form">
            <form method="get" action="<?= site_url('provincial/report'); ?>" class="form-inline w-100">
                <select name="event_id" class="form-control">
                    <option value="">Select event</option>
                    <?php foreach ($events as $ev): ?>
                        <option value="<?= (int)$ev->event_id; ?>" <?= ($selected_id === (int)$ev->event_id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($ev->event_name . ' (' . ($ev->group_name ?? 'Unspecified') . ')', ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary ml-2">Load</button>
                <button type="button" class="btn btn-outline-secondary ml-2 btn-back" onclick="window.history.back();">Back</button>
                <?php if ($selected_event): ?>
                    <button type="button" class="btn btn-success ml-auto btn-print" onclick="window.print();">
                        <i class="mdi mdi-printer"></i> Print
                    </button>
                <?php endif; ?>
            </form>
        </div>

        <div class="report-card">
            <div class="report-header">
                <img src="<?= base_url('assets/images/DepEd_logo.png'); ?>" alt="Logo" onerror="this.style.display='none';">
                <h3>Republic of the Philippines</h3>
                <h4>Department of Education</h4>
                <div class="meta">
                    REGION XI • SCHOOLS DIVISION OF DAVAO ORIENTAL<br>
                    Government Center, Dahican, City of Mati, Davao Oriental
                </div>
            </div>

            <?php if ($selected_event): ?>
                <div class="event-title">
                    Event: <?= htmlspecialchars($selected_event->event_name ?? '—', ENT_QUOTES, 'UTF-8'); ?>
                </div>

                <table class="table-report">
                    <thead>
                        <tr>
                            <th style="width:70px;">Rank</th>
                            <th>Name of Athlete/Team</th>
                            <th>Municipality</th>
                            <th>School</th>
                            <th>Coach</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($winners)): ?>
                            <?php
                            $rank = 1;
                            foreach ($winners as $w):
                                $fullName = !empty($w->full_name)
                                    ? $w->full_name
                                    : trim(($w->first_name ?? '') . ' ' . ($w->middle_name ?? '') . ' ' . ($w->last_name ?? ''));
                            ?>
                                <tr>
                                    <td style="text-align:center;"><?= $rank++; ?></td>
                                    <td><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($w->municipality ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($w->school ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($w->coach ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">No winners encoded for this event yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php
                $tournamentMgrs = array_filter($technical ?? array(), function($t){ return $t->role === 'Tournament Manager'; });
                $techOfficials  = array_filter($technical ?? array(), function($t){ return $t->role === 'Technical Official'; });
                ?>

                <div class="sign-row">
                    <div class="sign-slot">
                        Tournament Manager:<br>
                        <?= !empty($tournamentMgrs) ? htmlspecialchars(reset($tournamentMgrs)->name, ENT_QUOTES, 'UTF-8') : '________________________'; ?>
                    </div>
                    <div class="sign-slot">
                        Technical Officials:<br>
                        <?php
                        if (!empty($techOfficials)) {
                            $names = array_map(function($t){ return $t->name; }, $techOfficials);
                            echo htmlspecialchars(implode(', ', $names), ENT_QUOTES, 'UTF-8');
                        } else {
                            echo '________________________';
                        }
                        ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center text-muted py-4">
                    Select an event to generate the report.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
