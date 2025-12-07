<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    :root {
        --bg-gradient:
            url("data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20width='200'%20height='200'%20viewBox='0%200%20200%20200'%3E%3Cpath%20d='M-40%2040%20q50%20-30%20100%200%20t100%200%20t100%200'%20fill='none'%20stroke='rgba(255,255,255,0.2)'%20stroke-width='2'/%3E%3Cpath%20d='M-40%2080%20q50%20-30%20100%200%20t100%200%20t100%200'%20fill='none'%20stroke='rgba(255,255,255,0.18)'%20stroke-width='2'/%3E%3Cpath%20d='M-40%20120%20q50%20-30%20100%200%20t100%200%20t100%200'%20fill='none'%20stroke='rgba(255,255,255,0.16)'%20stroke-width='2'/%3E%3Cpath%20d='M-40%20160%20q50%20-30%20100%200%20t100%200%20t100%200'%20fill='none'%20stroke='rgba(255,255,255,0.14)'%20stroke-width='2'/%3E%3C/svg%3E"),
            linear-gradient(135deg, #f7f77a 0%, #b9f16b 25%, #4dd7a1 60%, #0fb7b4 100%);
        --card-bg: #ffffff;
        --card-border: #e2e8f0;
        --accent: #2563eb;
        --accent-soft: #e0e7ff;
        --muted: #6b7280;
        --text-main: #0f172a;
        --gold: #cfa000;
        --silver: #4b5563;
        --bronze: #c25a14;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: var(--app-font);
        background: var(--bg-gradient);
        color: var(--text-main);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    /* Subtle animated soft blobs */
    body::before,
    body::after {
        content: '';
        position: fixed;
        border-radius: 50%;
        opacity: 0.35;
        filter: blur(18px);
        z-index: 0;
        pointer-events: none;
        animation: glowFloat 26s ease-in-out infinite;
    }

    body::before {
        width: 520px;
        height: 520px;
        background: radial-gradient(circle, rgba(74, 222, 128, 0.4) 0, transparent 70%);
        top: -180px;
        right: -200px;
    }

    body::after {
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(253, 230, 138, 0.55) 0, transparent 70%);
        bottom: -150px;
        left: -200px;
        animation-delay: -11s;
    }

    @keyframes glowFloat {

        0%,
        100% {
            transform: translate3d(0, 0, 0) scale(1);
        }

        33% {
            transform: translate3d(24px, -18px, 0) scale(1.05);
        }

        66% {
            transform: translate3d(-18px, 18px, 0) scale(0.97);
        }
    }

    .landing-page-wrapper {
        min-height: 100vh;
        padding: 18px 12px 12px;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .landing-card {
        min-height: 0;
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .landing-card-inner {
        flex: 1 1 auto;
        max-width: 1180px;
        margin: 0 auto;
        width: 100%;
        padding: 18px 18px 20px;
        border-radius: 20px;
        border: 1px solid var(--card-border);
        background: radial-gradient(circle at 20% 24%, #ffffff 0, #f1f5f9 42%, #f8fafc 100%);
        box-shadow:
            0 14px 36px rgba(148, 163, 184, 0.28),
            0 0 0 1px rgba(226, 232, 240, 0.9);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: none;
    }

    .landing-card-inner::before {
        position: absolute;
        right: 40px;
        top: 30px;
        font-size: 0.7rem;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #9ca3af;
        font-weight: 700;
        pointer-events: none;
    }

    /* Header Section */
    .landing-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 14px;
        animation: headerDrop 0.4s ease-out;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 10px;
        flex-shrink: 0;
    }

    @keyframes headerDrop {
        from {
            opacity: 0;
            transform: translateY(-14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .landing-title h4 {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #2563eb;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .landing-title h4::before {
        content: '🏆';
        font-size: 1.2rem;
    }


    .landing-title h2 {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.03em;
        line-height: 1.05;
    }

    .landing-title small {
        color: var(--muted);
        font-size: 0.88rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 640px;
    }

    .landing-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    /* Group Pills – segmented control */
    .group-pills {
        display: inline-flex;
        gap: 0;
        align-items: stretch;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        box-shadow: 0 8px 18px rgba(148, 163, 184, 0.25);
        overflow: hidden;
    }

    .group-pills .btn {
        border-radius: 0;
        border: 0;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        position: relative;
        color: #6b7280;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 74px;
        transition: all 0.18s ease;
    }

    /* Banner hero */
    .banner-hero {
        position: relative;
        padding: 0;
        border-bottom: 0;
        margin-bottom: 18px;
    }

    .banner-image {
        width: 100%;
        height: 260px;
        min-height: 230px;
        max-height: 360px;
        border-radius: 18px;
        box-shadow: 0 16px 34px rgba(0, 0, 0, 0.18);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-color: #0f172a;
    }

    .banner-overlay {
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        padding: 8px 10px;
        background: rgba(15, 23, 42, 0.24);
        border-radius: 12px;
        backdrop-filter: blur(6px);
    }

    .group-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .group-pills .btn+.btn {
        border-left: 1px solid #e5e7eb;
    }

    .group-pills .btn-outline-primary {
        box-shadow: none;
    }

    .group-pills .btn-outline-primary:hover {
        color: #111827;
        background: #edf2ff;
    }

    .group-pills .btn-primary {
        color: #ffffff;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow:
            0 0 0 1px rgba(37, 99, 235, 0.4),
            0 12px 24px rgba(37, 99, 235, 0.55);
    }

    .group-pills .btn-primary:hover {
        filter: brightness(1.04);
    }

    .login-btn {
        padding: 7px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(156, 163, 175, 0.35);
        transition: all 0.18s ease;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .login-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.15), transparent 60%);
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .login-btn:hover {
        color: #1d4ed8;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow:
            0 0 0 1px rgba(37, 99, 235, 0.35),
            0 16px 26px rgba(148, 163, 184, 0.5);
    }

    .login-btn:hover::before {
        opacity: 1;
    }

    /* Summary Row */
    .summary-row {
        margin-bottom: 14px;
        margin-top: 4px;
        animation: summaryFade 0.4s ease-out 0.05s both;
        flex-shrink: 0;
    }

    @keyframes summaryFade {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .summary-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 12px 14px;
        border: 1px solid #e2e8f0;
        transition: all 0.22s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        box-shadow:
            0 12px 24px rgba(148, 163, 184, 0.25),
            0 0 0 1px rgba(226, 232, 240, 0.85);
    }

    .summary-card.clickable {
        cursor: pointer;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        inset: -40%;
        background:
            radial-gradient(circle at top left, rgba(191, 219, 254, 0.4), transparent 55%),
            radial-gradient(circle at bottom right, rgba(254, 243, 199, 0.4), transparent 55%);
        opacity: 0;
        transition: opacity 0.25s ease;
        pointer-events: none;
    }

    .summary-card:hover {
        transform: translateY(-2px) translateZ(0);
        box-shadow:
            0 20px 40px rgba(148, 163, 184, 0.4),
            0 0 0 1px rgba(59, 130, 246, 0.35);
        border-color: rgba(59, 130, 246, 0.6);
    }

    .summary-card:hover::before {
        opacity: 1;
    }

    .summary-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: #9ca3af;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .summary-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
        line-height: 1.08;
        display: flex;
        align-items: baseline;
        gap: 8px;
        flex-wrap: wrap;
    }

    .summary-sub {
        font-size: 0.85rem;
        color: var(--muted);
        line-height: 1.4;
    }

    /* Winners Table Wrapper */
    .winners-table-wrapper {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        box-shadow:
            0 18px 36px rgba(148, 163, 184, 0.32),
            0 0 0 1px rgba(226, 232, 240, 0.9);
        animation: tableReveal 0.4s ease-out 0.1s both;
        margin-top: 2px;
    }

    @keyframes tableReveal {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Live tally card palette pulled from meet banner */
    #liveTallyWrapper {
        background: linear-gradient(135deg, #f7e07b 0%, #f2c94c 35%, #e9b434 65%, #d59d1a 100%);
        border-color: rgba(213, 157, 26, 0.35);
    }

    #liveTallyWrapper .winners-toolbar {
        background: rgba(255, 255, 255, 0.24);
        backdrop-filter: blur(4px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.35);
    }

    #liveTallyWrapper .winners-heading,
    #liveTallyWrapper .winners-subtext {
        color: #3b2a0a;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.45);
    }

    /* Events with Results palette (match live tally) */
    #eventsRecordedPanel {
        background: linear-gradient(135deg, #f7e07b 0%, #f2c94c 35%, #e9b434 65%, #d59d1a 100%);
        border-color: rgba(213, 157, 26, 0.35);
    }

    #eventsRecordedPanel .winners-toolbar {
        background: rgba(255, 255, 255, 0.24);
        backdrop-filter: blur(4px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.35);
    }

    #eventsRecordedPanel .winners-heading,
    #eventsRecordedPanel .winners-subtext {
        color: #3b2a0a;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.45);
    }

    /* Medal breakdown palette (match live tally + events panel) */
    #medalBreakdownPanel {
        background: linear-gradient(135deg, #f7e07b 0%, #f2c94c 35%, #e9b434 65%, #d59d1a 100%);
        border-color: rgba(213, 157, 26, 0.35);
    }

    #medalBreakdownPanel .winners-toolbar {
        background: rgba(255, 255, 255, 0.24);
        backdrop-filter: blur(4px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.35);
    }

    #medalBreakdownPanel .winners-heading,
    #medalBreakdownPanel .winners-subtext {
        color: #3b2a0a;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.45);
    }

    /* Events modal header tint */
    #eventsRecordedModal .modal-content {
        background: linear-gradient(135deg, #fff9e6 0%, #fff4d0 45%, #ffe9a3 100%);
    }

    #eventsRecordedModal .modal-header,
    #eventsRecordedModal .modal-body {
        background: transparent;
    }

    .medal-icon {
        font-size: 1.25em;
        margin-right: 6px;
        vertical-align: middle;
    }

    .winners-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 14px;
        background: linear-gradient(to right, #eff6ff, #f9fafb);
        border-bottom: 1px solid #e5e7eb;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .winners-toolbar-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .winners-heading {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #111827;
    }

    .winners-subtext {
        margin: 0;
        color: var(--muted);
        font-size: 0.8rem;
    }

    .winners-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        font-size: 0.78rem;
        font-weight: 600;
        color: #111827;
        background: #ffffff;
        box-shadow: 0 4px 10px rgba(148, 163, 184, 0.2);
    }

    .filter-chip-primary {
        border-color: rgba(37, 99, 235, 0.4);
        background: #e0edff;
        color: #1d4ed8;
    }

    .filter-chip-accent {
        border-color: rgba(56, 189, 248, 0.5);
        background: #e0f2fe;
        color: #0369a1;
    }

    .filter-chip-muted {
        border-color: #e5e7eb;
        color: var(--muted);
        background: #f9fafb;
    }

    .team-logo {
        width: 48px;
        height: 48px;
        object-fit: cover;
        aspect-ratio: 1 / 1;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        padding: 0;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    }

    .medal-filter-link,
    .medal-filter {
        font-weight: 800;
        text-decoration: none;
    }

    /* Medal filter chips with matching fills */
    .filter-chip.medal-filter[data-medal="Gold"] {
        background: linear-gradient(180deg, rgba(255, 249, 196, 0.95), rgba(255, 236, 158, 0.8));
        border-color: rgba(255, 193, 7, 0.5);
        color: var(--gold);
    }

    .filter-chip.medal-filter[data-medal="Silver"] {
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.96), rgba(229, 231, 235, 0.82));
        border-color: rgba(160, 174, 192, 0.5);
        color: var(--silver);
    }

    .filter-chip.medal-filter[data-medal="Bronze"] {
        background: linear-gradient(180deg, rgba(255, 228, 203, 0.92), rgba(252, 196, 142, 0.78));
        border-color: rgba(226, 137, 44, 0.5);
        color: var(--bronze);
    }

    .medal-filter-link[data-medal="Gold"],
    .medal-filter[data-medal="Gold"] {
        color: var(--gold);
    }

    .medal-filter-link[data-medal="Silver"],
    .medal-filter[data-medal="Silver"] {
        color: var(--silver);
    }

    .medal-filter-link[data-medal="Bronze"],
    .medal-filter[data-medal="Bronze"] {
        color: var(--bronze);
    }

    .medal-filter-link[data-medal="All"] {
        color: var(--accent);
    }

    /* Medal columns tint */
    .col-gold {
        background: linear-gradient(180deg, rgba(255, 249, 196, 0.95), rgba(255, 236, 158, 0.75));
        color: var(--gold);
    }

    .col-silver {
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.95), rgba(229, 231, 235, 0.75));
        color: var(--silver);
    }

    .col-bronze {
        background: linear-gradient(180deg, rgba(255, 228, 203, 0.9), rgba(252, 196, 142, 0.7));
        color: var(--bronze);
    }

    .medal-head-gold,
    .medal-head-silver,
    .medal-head-bronze,
    .winners-table thead th.col-gold,
    .winners-table thead th.col-silver,
    .winners-table thead th.col-bronze {
        font-weight: 800;
        border-bottom: 1px solid #e5e7eb;
    }

    /* Header colors match the data cell fills */
    .medal-head-gold,
    .winners-table thead th.col-gold {
        background: linear-gradient(180deg, rgba(255, 249, 196, 0.98), rgba(255, 236, 158, 0.86));
        color: var(--gold);
    }

    .medal-head-silver,
    .winners-table thead th.col-silver {
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.98), rgba(229, 231, 235, 0.88));
        color: var(--silver);
    }

    .medal-head-bronze,
    .winners-table thead th.col-bronze {
        background: linear-gradient(180deg, rgba(255, 228, 203, 0.95), rgba(252, 196, 142, 0.82));
        color: var(--bronze);
    }

    .medal-icon {
        font-size: 1.05rem;
        margin-right: 4px;
        vertical-align: middle;
    }

    .winners-table tbody tr:hover td.col-gold {
        background: linear-gradient(180deg, rgba(255, 249, 196, 0.98), rgba(255, 231, 148, 0.82));
    }

    .winners-table tbody tr:hover td.col-silver {
        background: linear-gradient(180deg, rgba(252, 253, 255, 0.98), rgba(229, 231, 235, 0.85));
    }

    .winners-table tbody tr:hover td.col-bronze {
        background: linear-gradient(180deg, rgba(255, 228, 203, 0.96), rgba(252, 189, 126, 0.8));
    }

    .has-medal-row {
        background: linear-gradient(90deg, rgba(240, 249, 255, 0.55), rgba(238, 242, 255, 0.65));
    }

    .has-medal-row:hover {
        background: linear-gradient(90deg, rgba(224, 242, 255, 0.7), rgba(224, 231, 255, 0.78));
    }

    .clear-filter-btn {
        border-radius: 999px;
        font-weight: 600;
        padding: 6px 14px;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
    }

    .table-responsive {
        flex: 0 1 auto;
        overflow-y: visible;
    }

    .winners-table {
        margin: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .winners-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .winners-table thead th {
        background: linear-gradient(to bottom, #f3f4f6 0%, #e5e7eb 100%);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        font-weight: 700;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
        padding: 9px 10px;
        white-space: nowrap;
        border-top: none;
        position: relative;
    }

    .winners-table thead th::after {
        content: '';
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 2px;
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(209, 213, 219, 0.9), transparent);
        opacity: 0.8;
    }

    .winners-table tbody tr {
        background: #ffffff;
        transition: background-color 0.16s ease, transform 0.08s ease;
    }

    .winners-table tbody td {
        padding: 9px 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
        color: #111827;
    }

    .winners-table tbody tr:hover {
        background: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(148, 163, 184, 0.45);
    }

    .winners-table tbody tr:last-child td {
        border-bottom: none;
    }

    .winners-table tbody tr.no-results-row,
    .winners-table tbody tr.no-results-row:hover {
        background: #ffffff;
        box-shadow: none;
        transform: none;
    }

    /* Medal Chips – light theme */
    .chip-medal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        border: 2px solid;
        min-width: 86px;
        transition: all 0.2s ease;
        box-shadow:
            0 0 0 1px rgba(148, 163, 184, 0.3),
            0 8px 18px rgba(148, 163, 184, 0.35);
    }

    .chip-medal:hover {
        transform: translateY(-1px) scale(1.02);
        box-shadow:
            0 0 0 1px rgba(148, 163, 184, 0.5),
            0 14px 30px rgba(148, 163, 184, 0.55);
    }

    .chip-gold {
        background: linear-gradient(135deg, #fff3bf, #ffdd57);
        color: #8b6500;
        border-color: #eab308;
        box-shadow:
            0 0 18px rgba(251, 191, 36, 0.4),
            0 0 0 1px rgba(248, 250, 252, 1);
    }

    .chip-silver {
        background: linear-gradient(135deg, #f9fafb, #e5e7eb);
        color: #374151;
        border-color: #9ca3af;
        box-shadow:
            0 0 18px rgba(156, 163, 175, 0.35),
            0 0 0 1px rgba(248, 250, 252, 1);
    }

    .chip-bronze {
        background: linear-gradient(135deg, #ffd9b0, #f7a258);
        color: #7a2e0a;
        border-color: #d97706;
        box-shadow:
            0 0 18px rgba(248, 153, 82, 0.45),
            0 0 0 1px rgba(248, 250, 252, 1);
    }

    /* Footer */
    .footer-note {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px dashed #e5e7eb;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        font-size: 0.78rem;
        color: var(--muted);
        font-weight: 500;
        gap: 8px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .footer-note span {
        text-align: right;
    }

    /* Team picker + modal table – light styling */
    .municipality-picker {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 12px;
    }

    .municipality-picker-label {
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
        display: block;
        font-size: 0.86rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .municipality-picker-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .municipality-picker select {
        min-width: 220px;
        background-color: #ffffff;
        border-color: #d1d5db;
        color: #111827;
    }

    .municipality-picker select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.5);
    }

    .municipality-empty {
        text-align: center;
        color: var(--muted);
        padding: 10px 0;
    }

    /* Modal light theme */
    .modal-content {
        background: #ffffff;
        color: #111827;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        box-shadow:
            0 26px 70px rgba(148, 163, 184, 0.6),
            0 0 0 1px rgba(226, 232, 240, 0.9);
    }

    .modal-header {
        border-bottom-color: #e5e7eb;
        background: #f9fafb;
    }

    .modal-title {
        font-size: 0.95rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #111827;
    }

    .modal-body {
        background: #ffffff;
    }

    .modal-footer {
        border-top-color: #e5e7eb;
        background: #f9fafb;
    }

    .modal .table thead th {
        background: #f3f4f6;
        border-bottom-color: #e5e7eb;
        color: #4b5563;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .modal .table tbody td {
        border-bottom-color: #e5e7eb;
        color: #111827;
        font-size: 0.9rem;
    }

    .modal .btn-light {
        background-color: #ffffff;
        border-color: #e5e7eb;
        color: #111827;
    }

    .modal .btn-light:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    /* Loader – soft light overlay */
    .loader-wrapper {
        position: fixed;
        inset: 0;
        z-index: 50;
        background: radial-gradient(circle at top left, #dbeafe 0, #eff6ff 40%, #f9fafb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader {
        position: relative;
        width: 120px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .loader-bar {
        width: 14px;
        height: 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, #60a5fa, #4f46e5);
        box-shadow: 0 0 10px rgba(96, 165, 250, 0.85);
        animation: pulseBars 0.9s infinite ease-in-out;
    }

    .loader-bar:nth-child(2) {
        animation-delay: 0.08s;
    }

    .loader-bar:nth-child(3) {
        animation-delay: 0.16s;
    }

    .loader-bar:nth-child(4) {
        animation-delay: 0.24s;
    }

    .loader-bar:nth-child(5) {
        animation-delay: 0.32s;
    }

    .loader-ball {
        position: absolute;
        left: 0;
        width: 14px;
        height: 14px;
        border-radius: 999px;
        background: radial-gradient(circle at top left, #fb923c, #facc15);
        box-shadow: 0 0 12px rgba(251, 146, 60, 0.9);
        animation: slideBall 1.2s infinite cubic-bezier(0.55, 0.15, 0.35, 0.85);
    }

    @keyframes pulseBars {

        0%,
        100% {
            transform: translateY(0) scale(0.9);
            opacity: 0.4;
        }

        40% {
            transform: translateY(-6px) scale(1.1);
            opacity: 1;
        }
    }

    @keyframes slideBall {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(106px);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .landing-page-wrapper {
            padding: 18px 10px;
        }

        .landing-card-inner {
            padding: 20px 18px 20px;
        }

        .landing-header {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .landing-title h2 {
            font-size: 1.9rem;
        }

        .group-pills {
            width: 100%;
            justify-content: space-between;
        }

        .group-pills .btn {
            flex: 1;
            min-width: 0;
        }

        .summary-value {
            font-size: 1.7rem;
        }

        .winners-table thead th {
            font-size: 0.7rem;
            padding-inline: 10px;
        }

        .winners-table tbody td {
            padding-inline: 10px;
            font-size: 0.85rem;
        }

        .winners-toolbar {
            align-items: flex-start;
        }

        .winners-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .landing-card-inner::before {
            right: 22px;
            top: 20px;
        }

        .footer-note {
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .landing-card-inner {
            padding-inline: 14px;
            max-height: none;
        }

        .landing-title h2 {
            font-size: 1.6rem;
        }

        .landing-title small {
            font-size: 0.85rem;
        }

        .landing-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .group-pills {
            order: 1;
        }

        .banner-overlay {
            flex-direction: column;
            align-items: stretch;
        }

        .group-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .login-btn {
            width: 100%;
            justify-content: center;
        }

        /* Tighter live tally on phones */
        #liveTallyWrapper .winners-table th,
        #liveTallyWrapper .winners-table td {
            padding: 4px 4px;
            font-size: 0.82rem;
        }

        #liveTallyWrapper .winners-table {
            table-layout: fixed;
            width: 100%;
        }

        #liveTallyWrapper .winners-table th:first-child,
        #liveTallyWrapper .winners-table td:first-child {
            width: 38%;
        }

        #liveTallyWrapper .winners-table th:nth-child(n+2),
        #liveTallyWrapper .winners-table td:nth-child(n+2) {
            width: 15.5%;
        }

        .team-logo {
            width: 40px;
            height: 40px;
        }

        .banner-image {
            height: 220px;
            min-height: 200px;
            max-height: 260px;
        }

        /* Fit live tally without scrolling */
        #liveTallyWrapper .winners-table {
            table-layout: fixed;
            width: 100%;
        }

        #liveTallyWrapper .winners-table th,
        #liveTallyWrapper .winners-table td {
            padding: 6px 5px;
            font-size: 0.82rem;
        }

        #liveTallyWrapper .winners-table th:first-child,
        #liveTallyWrapper .winners-table td:first-child {
            width: 40%;
        }

        #liveTallyWrapper .winners-table th:nth-child(n+2),
        #liveTallyWrapper .winners-table td:nth-child(n+2) {
            width: 15%;
        }

        #liveTallyWrapper .winners-table th {
            letter-spacing: 0.04em;
            word-spacing: 0.25em;
        }

        .chip-medal {
            min-width: 78px;
            padding-inline: 16px;
            font-size: 0.68rem;
        }

        .winners-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .winners-actions .clear-filter-btn {
            width: 100%;
            text-align: center;
        }

        .landing-card-inner::before {
            display: none;
        }

        .landing-title small {
            -webkit-line-clamp: 3;
        }
    }
</style>

<body>

    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-ball"></div>
        </div>
    </div>

    <section class="landing-page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 landing-card">
                    <div class="landing-card-inner">

                        <!-- Header Banner -->
                        <div class="landing-header banner-hero">
                            <?php
                            $meet_title = isset($meet->meet_title) ? $meet->meet_title : 'Provincial Meet';
                            $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : '';
                            $activeMunicipalityHeader = isset($active_municipality) ? trim((string) $active_municipality) : '';
                            $activeMunicipalityFilter = $activeMunicipalityHeader;
                            $group = isset($active_group) ? $active_group : 'ALL';
                            $baseLandingUrl = site_url('provincial');
                            $makeGroupUrl = function ($targetGroup) use ($activeMunicipalityFilter, $baseLandingUrl) {
                                $params = array();
                                if ($activeMunicipalityFilter !== '') {
                                    $params[] = 'municipality=' . urlencode($activeMunicipalityFilter);
                                }
                                if ($targetGroup === 'Elementary' || $targetGroup === 'Secondary') {
                                    $params[] = 'group=' . urlencode($targetGroup);
                                }
                                $query = empty($params) ? '' : '?' . implode('&', $params);
                                return $baseLandingUrl . $query;
                            };
                            $isLoggedIn = isset($this) && isset($this->session) ? (bool)$this->session->userdata('logged_in') : false;
                            $loginUrl   = $isLoggedIn ? site_url('provincial/admin') : site_url('login');
                            $loginText  = $isLoggedIn ? 'Admin Dashboard' : 'Login';
                            ?>
                            <?php if ($activeMunicipalityHeader === ''): ?>
                                <img src="<?= base_url('upload/banners/Banner.png'); ?>" alt="<?= htmlspecialchars($meet_title . ' banner', ENT_QUOTES, 'UTF-8'); ?>" class="banner-image">
                            <?php else: ?>
                                <div class="landing-title">
                                    <h4>Official Result Board</h4>
                                    <h2 style="margin-bottom:4px;"><?= htmlspecialchars($activeMunicipalityHeader, ENT_QUOTES, 'UTF-8'); ?></h2>
                                    <small>Viewing team details and standings. Use the tabs below to switch groups.</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Group/login controls -->
                        <div class="group-bar">
                            <div class="group-pills">
                                <a href="<?= $makeGroupUrl('ALL'); ?>"
                                    class="btn btn-sm <?= $group === 'ALL' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    Overall
                                </a>
                                <a href="<?= $makeGroupUrl('Elementary'); ?>"
                                    class="btn btn-sm <?= $group === 'Elementary' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    Elementary
                                </a>
                                <a href="<?= $makeGroupUrl('Secondary'); ?>"
                                    class="btn btn-sm <?= $group === 'Secondary' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                    Secondary
                                </a>
                            </div>
                            <a href="<?= $loginUrl; ?>" class="login-btn" title="Admin">
                                <?= $loginText; ?>
                            </a>
                        </div>

                        <!-- Summary row -->
                        <?php
                        $overview       = isset($overview) ? $overview : null;
                        $activeMunicipality = isset($active_municipality) ? $active_municipality : '';
                        $teamsTotal     = isset($municipalities_all) && is_array($municipalities_all) ? count($municipalities_all) : 0;
                        $municipalities = $teamsTotal;
                        $events         = $overview ? (int)$overview->events : 0;
                        $goldTotal      = $overview ? (int)$overview->gold : 0;
                        $silverTotal    = $overview ? (int)$overview->silver : 0;
                        $bronzeTotal    = $overview ? (int)$overview->bronze : 0;
                        $totalMedals    = $overview ? (int)$overview->total_medals : 0;
                        $lastUpdate     = ($overview && $overview->last_update)
                            ? date('M d, Y h:i A', strtotime($overview->last_update))
                            : 'No data yet';

                        $tally = isset($municipality_tally) ? $municipality_tally : array();
                        $allMunicipalities = isset($municipalities_all) ? $municipalities_all : array();
                        $logoMap = isset($municipality_logos) ? $municipality_logos : array();

                        $normalizeName = function ($name) {
                            return strtolower(trim((string) $name));
                        };
                        $tallyMap = array();
                        foreach ($tally as $row) {
                            $key = $normalizeName(isset($row->municipality) ? $row->municipality : '');
                            if ($key === '') continue;
                            $tallyMap[$key] = $row;
                        }

                        // Prepare medal-sorted winners and event summaries (used by panels)
                        $winnersSorted = $winners ?? array();
                        if (!empty($winnersSorted) && is_array($winnersSorted)) {
                            usort($winnersSorted, function ($a, $b) {
                                $weight = ['Gold' => 3, 'Silver' => 2, 'Bronze' => 1];
                                $medalDiff = ($weight[$b->medal] ?? 0) - ($weight[$a->medal] ?? 0);
                                if ($medalDiff !== 0) return $medalDiff;
                                $eventDiff = strcasecmp($a->event_name ?? '', $b->event_name ?? '');
                                if ($eventDiff !== 0) return $eventDiff;
                                return strcasecmp($a->municipality ?? '', $b->municipality ?? '');
                            });
                        }
                        $eventSummaries = array();
                        foreach ($winnersSorted as $w) {
                            $eventId = $w->event_id ?? null;
                            $key = $eventId !== null ? 'id-' . $eventId : 'name-' . md5(($w->event_name ?? '') . ($w->event_group ?? '') . ($w->category ?? ''));
                            if (!isset($eventSummaries[$key])) {
                                $eventSummaries[$key] = array(
                                    'event_name' => $w->event_name ?? 'Unknown Event',
                                    'event_group' => $w->event_group ?? '-',
                                    'category' => $w->category ?? '-',
                                    'gold' => 0,
                                    'silver' => 0,
                                    'bronze' => 0,
                                    'teams' => array(),
                                    'gold_teams' => array(),
                                    'silver_teams' => array(),
                                    'bronze_teams' => array()
                                );
                            }
                            $teamName = trim((string)($w->municipality ?? ''));
                            if ($teamName !== '' && !in_array($teamName, $eventSummaries[$key]['teams'], true)) {
                                $eventSummaries[$key]['teams'][] = $teamName;
                            }
                            $medal = strtolower($w->medal ?? '');
                            if ($medal === 'gold') {
                                $eventSummaries[$key]['gold'] += 1;
                                if ($teamName !== '' && !in_array($teamName, $eventSummaries[$key]['gold_teams'], true)) {
                                    $eventSummaries[$key]['gold_teams'][] = $teamName;
                                }
                            } elseif ($medal === 'silver') {
                                $eventSummaries[$key]['silver'] += 1;
                                if ($teamName !== '' && !in_array($teamName, $eventSummaries[$key]['silver_teams'], true)) {
                                    $eventSummaries[$key]['silver_teams'][] = $teamName;
                                }
                            } elseif ($medal === 'bronze') {
                                $eventSummaries[$key]['bronze'] += 1;
                                if ($teamName !== '' && !in_array($teamName, $eventSummaries[$key]['bronze_teams'], true)) {
                                    $eventSummaries[$key]['bronze_teams'][] = $teamName;
                                }
                            }
                        }
                        $eventSummaries = array_values($eventSummaries);
                        usort($eventSummaries, function ($a, $b) {
                            return strcasecmp($a['event_name'], $b['event_name']);
                        });
                        // Fallback: if no winners list was provided, build summaries from events_list counts
                        if (empty($eventSummaries) && !empty($events_list) && is_array($events_list)) {
                            foreach ($events_list as $ev) {
                                $g = isset($ev->gold_count) ? (int) $ev->gold_count : 0;
                                $s = isset($ev->silver_count) ? (int) $ev->silver_count : 0;
                                $b = isset($ev->bronze_count) ? (int) $ev->bronze_count : 0;
                                $total = $g + $s + $b;
                                if ($total <= 0) continue;
                                $key = isset($ev->event_id) ? 'id-' . $ev->event_id : 'name-' . md5(($ev->event_name ?? '') . ($ev->group_name ?? '') . ($ev->category_name ?? ''));
                                if (!isset($eventSummaries[$key])) {
                                    $eventSummaries[$key] = array(
                                        'event_name' => $ev->event_name ?? 'Unknown Event',
                                        'event_group' => $ev->group_name ?? '-',
                                        'category' => $ev->category_name ?? '-',
                                        'gold' => 0,
                                        'silver' => 0,
                                        'bronze' => 0,
                                        'teams' => array()
                                    );
                                }
                                $eventSummaries[$key]['gold'] += $g;
                                $eventSummaries[$key]['silver'] += $s;
                                $eventSummaries[$key]['bronze'] += $b;
                            }
                            $eventSummaries = array_values($eventSummaries);
                            usort($eventSummaries, function ($a, $b) {
                                return strcasecmp($a['event_name'], $b['event_name']);
                            });
                        }
                        ?>

                        <?php if (empty($activeMunicipality)): ?>
                            <div class="row summary-row">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="summary-card clickable" id="municipalityCard"
                                        data-toggle="modal" data-target="#municipalityModal"
                                        data-bs-toggle="modal" data-bs-target="#municipalityModal"
                                        role="button" tabindex="0">
                                        <div class="summary-label">Participating Teams</div>
                                        <div class="summary-value" id="stat-municipalities"><?= $municipalities; ?></div>
                                        <!-- <div class="summary-sub">Total registered teams</div> -->
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="summary-card clickable" id="eventsRecordedCard" role="button" tabindex="0"
                                        aria-label="View events with posted results">
                                        <div class="summary-label">Events Recorded</div>
                                        <div class="summary-value" id="stat-events"><?= $events; ?></div>
                                        <!-- <div class="summary-sub">completed with reported winners</div> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-card clickable" id="totalMedalsCard" role="button" tabindex="0"
                                        aria-label="View medal breakdown">
                                        <div class="summary-label">Total Medals</div>
                                        <div class="summary-value">
                                            <span id="stat-total-medals"><?= $totalMedals; ?></span>
                                            <span id="stat-medal-breakdown"
                                                style="font-size:0.9rem;font-weight:700;color:#2563eb;">
                                                (<span class="medal-filter" data-medal="Gold" style="cursor:pointer;"><?= $goldTotal; ?>G</span>
                                                · <span class="medal-filter" data-medal="Silver" style="cursor:pointer;"><?= $silverTotal; ?>S</span>
                                                · <span class="medal-filter" data-medal="Bronze" style="cursor:pointer;"><?= $bronzeTotal; ?>B</span>)
                                            </span>
                                        </div>
                                        <!--<div class="summary-sub">-->
                                        <!--    Last update:-->
                                        <!--    <span id="stat-last-update"><?= $lastUpdate; ?></span>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>

                            <!-- Participating Teams (default view) -->
                            <?php
                            $teamRows = is_array($allMunicipalities) ? $allMunicipalities : array();
                            if (!empty($teamRows)) {
                                usort($teamRows, function ($a, $b) use ($tallyMap, $normalizeName) {
                                    $aName = isset($a->municipality) ? trim($a->municipality) : '';
                                    $bName = isset($b->municipality) ? trim($b->municipality) : '';
                                    $aKey = $normalizeName($aName);
                                    $bKey = $normalizeName($bName);
                                    $aStats = $tallyMap[$aKey] ?? null;
                                    $bStats = $tallyMap[$bKey] ?? null;
                                    $aGold = $aStats ? (int) $aStats->gold : 0;
                                    $bGold = $bStats ? (int) $bStats->gold : 0;
                                    if ($aGold !== $bGold) return $bGold - $aGold;
                                    $aSilver = $aStats ? (int) $aStats->silver : 0;
                                    $bSilver = $bStats ? (int) $bStats->silver : 0;
                                    if ($aSilver !== $bSilver) return $bSilver - $aSilver;
                                    $aBronze = $aStats ? (int) $aStats->bronze : 0;
                                    $bBronze = $bStats ? (int) $bStats->bronze : 0;
                                    if ($aBronze !== $bBronze) return $bBronze - $aBronze;
                                    $aTotal = $aStats ? (int) $aStats->total_medals : 0;
                                    $bTotal = $bStats ? (int) $bStats->total_medals : 0;
                                    if ($aTotal !== $bTotal) return $bTotal - $aTotal;
                                    return strcasecmp($aName, $bName);
                                });
                            }
                            $groupParam = ($group === 'ALL') ? '' : '&group=' . urlencode($group);
                            ?>
                            <div class="winners-table-wrapper mt-4" id="liveTallyWrapper">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading">Official Results Board - Live Tally</h5>
                                        <p class="winners-subtext mb-0">Last update:
                                            <span id="stat-last-update"><?= $lastUpdate; ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th>Team</th>
                                                <th class="text-center col-gold"><span class="medal-icon">🥇</span>Gold</th>
                                                <th class="text-center col-silver"><span class="medal-icon">🥈</span>Silver</th>
                                                <th class="text-center col-bronze"><span class="medal-icon">🥉</span>Bronze</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($teamRows)): ?>
                                                <?php foreach ($teamRows as $row): ?>
                                                    <?php
                                                    $mName = isset($row->municipality) ? $row->municipality : '';
                                                    $mKey = $normalizeName($mName);
                                                    $stats = $tallyMap[$mKey] ?? null;
                                                    $hasData = $stats && ((int)$stats->total_medals > 0 || (int)$stats->gold > 0 || (int)$stats->silver > 0 || (int)$stats->bronze > 0);
                                                    $gold = $stats ? (int) $stats->gold : 0;
                                                    $silver = $stats ? (int) $stats->silver : 0;
                                                    $bronze = $stats ? (int) $stats->bronze : 0;
                                                    $total = $stats ? (int) $stats->total_medals : 0;
                                                    $goldClass = ($gold > 0) ? ' col-gold' : '';
                                                    $silverClass = ($silver > 0) ? ' col-silver' : '';
                                                    $bronzeClass = ($bronze > 0) ? ' col-bronze' : '';
                                                    $logo = isset($logoMap[$mName]) ? $logoMap[$mName] : '';
                                                    $filterUrl = site_url('provincial?municipality=' . urlencode($mName) . $groupParam);
                                                    ?>
                                                    <tr>
                                                        <td class="align-middle">
                                                            <a href="<?= $filterUrl; ?>" class="d-flex align-items-center" style="gap:10px; text-decoration:none; color:inherit;">
                                                                <?php if (!empty($logo)): ?>
                                                                    <img src="<?= base_url('upload/team_logos/' . $logo); ?>" alt="<?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                                <?php endif; ?>
                                                                <span><?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?></span>
                                                            </a>
                                                        </td>
                                                        <td class="text-center font-weight-bold<?= $goldClass; ?>">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="Gold"><?= $gold; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold<?= $silverClass; ?>">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="Silver"><?= $silver; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold<?= $bronzeClass; ?>">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="Bronze"><?= $bronze; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                        <td class="text-center font-weight-bold">
                                                            <?php if ($hasData): ?>
                                                                <a href="<?= $filterUrl; ?>" class="medal-filter-link" data-medal="All"><?= $total; ?></a>
                                                                <?php else: ?>—<?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="5" class="text-center py-4 text-muted">No teams found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="winners-table-wrapper mt-3" id="eventsRecordedPanel" style="display:none;">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading mb-0">Events with Results</h5>
                                        <p class="winners-subtext mb-0">All events that already have encoded medals.</p>
                                    </div>
                                    <div class="winners-actions">
                                        <button class="btn btn-sm btn-light" id="hideEventsPanel">Hide</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center col-gold"><span class="medal-icon">🥇</span>Gold</th>
                                                <th class="text-center col-silver"><span class="medal-icon">🥈</span>Silver</th>
                                                <th class="text-center col-bronze"><span class="medal-icon">🥉</span>Bronze</th>
                                            </tr>
                                        </thead>
                                        <tbody id="eventsRecordedBody">
                                            <?php if (!empty($eventSummaries)): ?>
                                                <?php foreach ($eventSummaries as $ev): ?>
                                                    <?php
                                                    $gold = (int) $ev['gold'];
                                                    $silver = (int) $ev['silver'];
                                                    $bronze = (int) $ev['bronze'];
                                                    $total = $gold + $silver + $bronze;
                                                    $goldCls = $gold > 0 ? ' col-gold' : '';
                                                    $silverCls = $silver > 0 ? ' col-silver' : '';
                                                    $bronzeCls = $bronze > 0 ? ' col-bronze' : '';
                                                    $rowCls = $total > 0 ? ' class="has-medal-row"' : '';
                                                    $goldTeams = !empty($ev['gold_teams']) ? implode(', ', $ev['gold_teams']) : '—';
                                                    $silverTeams = !empty($ev['silver_teams']) ? implode(', ', $ev['silver_teams']) : '—';
                                                    $bronzeTeams = !empty($ev['bronze_teams']) ? implode(', ', $ev['bronze_teams']) : '—';
                                                    ?>
                                                    <tr<?= $rowCls; ?>>
                                                        <td><?= htmlspecialchars($ev['event_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($ev['event_group'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($ev['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold<?= $goldCls; ?>"><?= htmlspecialchars($goldTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold<?= $silverCls; ?>"><?= htmlspecialchars($silverTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center font-weight-bold<?= $bronzeCls; ?>"><?= htmlspecialchars($bronzeTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr class="no-results-row">
                                                        <td colspan="6" class="text-center py-4 text-muted">
                                                            No events with posted results yet.
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <?php ?>
                            <div class="winners-table-wrapper mt-3" id="medalBreakdownPanel" style="display:none;">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading mb-0">Medal Breakdown</h5>
                                        <p class="winners-subtext mb-0">All events with medals (sorted Gold → Bronze).</p>
                                    </div>
                                    <div class="winners-actions">
                                        <button class="btn btn-sm btn-light" id="hideMedalBreakdown">Hide</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width:180px;">Event</th>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Category</th>
                                                <th>Winner</th>
                                                <th class="text-center">Medal</th>
                                                <th>Team</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($winnersSorted)): ?>
                                                <?php foreach ($winnersSorted as $w): ?>
                                                    <?php
                                                    $medal = $w->medal ?? 'Silver';
                                                    $chipClass = 'chip-silver';
                                                    if ($medal === 'Gold') $chipClass = 'chip-gold';
                                                    elseif ($medal === 'Bronze') $chipClass = 'chip-bronze';
                                                    $fullName = '';
                                                    if (!empty($w->full_name)) {
                                                        $fullName = $w->full_name;
                                                    } else {
                                                        $fullNameParts = array_filter(array($w->first_name ?? '', $w->middle_name ?? '', $w->last_name ?? ''));
                                                        $fullName = implode(' ', $fullNameParts);
                                                    }
                                                    $teamLogo = $logoMap[$w->municipality ?? ''] ?? '';
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($w->event_name ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($w->event_group ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($w->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-center">
                                                            <span class="chip-medal <?= $chipClass; ?>"><?= htmlspecialchars($medal, ENT_QUOTES, 'UTF-8'); ?></span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center" style="gap:8px;">
                                                                <?php if (!empty($teamLogo)): ?>
                                                                    <img src="<?= base_url('upload/team_logos/' . $teamLogo); ?>" alt="<?= htmlspecialchars($w->municipality ?? '', ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                                <?php endif; ?>
                                                                <span><?= htmlspecialchars($w->municipality ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="6" class="text-center py-4 text-muted">No medal data yet.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php
                            $selectedName = $activeMunicipality;
                            $selectedKey = $normalizeName($selectedName);
                            $teamStats = $tallyMap[$selectedKey] ?? null;
                            $teamGold = $teamStats ? (int) $teamStats->gold : 0;
                            $teamSilver = $teamStats ? (int) $teamStats->silver : 0;
                            $teamBronze = $teamStats ? (int) $teamStats->bronze : 0;
                            $teamTotal = $teamStats ? (int) $teamStats->total_medals : 0;
                            $teamLogo = isset($logoMap[$selectedName]) ? $logoMap[$selectedName] : '';
                            $backUrl = site_url('provincial' . ($group === 'ALL' ? '' : '?group=' . urlencode($group)));
                            ?>

                            <div class="winners-table-wrapper mt-4">
                                <div class="winners-toolbar">
                                    <div class="winners-toolbar-left">
                                        <h5 class="winners-heading">Team Dashboard</h5>
                                        <p class="winners-subtext mb-0">
                                            Viewing all encoded events for <strong><?= htmlspecialchars($selectedName, ENT_QUOTES, 'UTF-8'); ?></strong>.
                                        </p>
                                    </div>
                                    <div class="winners-actions">
                                        <div class="filter-chip filter-chip-primary medal-filter" data-medal="Gold">Gold: <?= $teamGold; ?></div>
                                        <div class="filter-chip filter-chip-accent medal-filter" data-medal="Silver">Silver: <?= $teamSilver; ?></div>
                                        <div class="filter-chip filter-chip-muted medal-filter" data-medal="Bronze">Bronze: <?= $teamBronze; ?></div>
                                        <div class="filter-chip" id="clearMedalFilter" style="cursor:pointer;">Show All</div>
                                        <a class="btn btn-sm btn-light" href="<?= $backUrl; ?>">← Back to all teams</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0 winners-table">
                                        <thead>
                                            <tr>
                                                <th style="min-width:180px;">Event</th>
                                                <th class="text-center">Group</th>
                                                <th class="text-center">Category</th>
                                                <th>Name</th>
                                                <th class="text-center">Medal</th>
                                                <!-- School/Coach removed per request -->
                                            </tr>
                                        </thead>
                                        <tbody id="winners-body">
                                            <?php if (!empty($winners)): ?>
                                                <?php foreach ($winners as $w): ?>
                                                    <?php
                                                    $medal = isset($w->medal) ? $w->medal : 'Silver';
                                                    $chipClass = 'chip-silver';
                                                    if ($medal === 'Gold') $chipClass = 'chip-gold';
                                                    elseif ($medal === 'Bronze') $chipClass = 'chip-bronze';
                                                    $fullName = '';
                                                    if (!empty($w->full_name)) {
                                                        $fullName = $w->full_name;
                                                    } else {
                                                        $fullNameParts = array_filter(array($w->first_name ?? '', $w->middle_name ?? '', $w->last_name ?? ''));
                                                        $fullName = implode(' ', $fullNameParts);
                                                    }
                                                    ?>
                                                    <tr data-medal="<?= htmlspecialchars($medal, ENT_QUOTES, 'UTF-8'); ?>">
                                                        <td class="align-middle">
                                                            <span><?= htmlspecialchars($w->event_name ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                                        </td>
                                                        <td class="align-middle text-center"><?= htmlspecialchars($w->event_group ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="align-middle text-center"><?= htmlspecialchars($w->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="align-middle"><?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="align-middle text-center">
                                                            <span class="chip-medal <?= $chipClass; ?>"><?= htmlspecialchars($medal, ENT_QUOTES, 'UTF-8'); ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="5" class="text-center py-5 text-muted">
                                                        No encoded events for this team yet.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="footer-note">
                            <!-- <span>
                                For questions or clarification on these results, please coordinate with the Meet Coordinator.
                            </span> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    ?>
    <!-- Participating Teams Modal -->
    <?php
    $tally = isset($municipality_tally) ? $municipality_tally : array();
    $allMunicipalities = isset($municipalities_all) ? $municipalities_all : array();
    $groupContext = isset($active_group) ? $active_group : 'ALL';
    $baseUrl = site_url('provincial');
    $groupQuery = ($groupContext === 'Elementary' || $groupContext === 'Secondary')
        ? '&group=' . urlencode($groupContext)
        : '';
    $tallyMap = array();
    $normalizeName = function ($name) {
        return strtolower(trim((string) $name));
    };
    foreach ($tally as $row) {
        $key = $normalizeName(isset($row->municipality) ? $row->municipality : '');
        if ($key === '') {
            continue;
        }
        $tallyMap[$key] = $row;
    }
    // Order municipalities by medal tally (gold > silver > bronze) and place those with no data after
    $sortedMunicipalities = is_array($allMunicipalities) ? $allMunicipalities : array();
    if (!empty($sortedMunicipalities)) {
        usort($sortedMunicipalities, function ($a, $b) use ($tallyMap, $normalizeName) {
            $aName = isset($a->municipality) ? trim($a->municipality) : '';
            $bName = isset($b->municipality) ? trim($b->municipality) : '';

            $aKey = $normalizeName($aName);
            $bKey = $normalizeName($bName);

            $aStats = isset($tallyMap[$aKey]) ? $tallyMap[$aKey] : null;
            $bStats = isset($tallyMap[$bKey]) ? $tallyMap[$bKey] : null;

            if ($aStats && $bStats) {
                $goldDiff = (int) $bStats->gold - (int) $aStats->gold;
                if ($goldDiff !== 0) {
                    return $goldDiff;
                }
                $silverDiff = (int) $bStats->silver - (int) $aStats->silver;
                if ($silverDiff !== 0) {
                    return $silverDiff;
                }
                $bronzeDiff = (int) $bStats->bronze - (int) $aStats->bronze;
                if ($bronzeDiff !== 0) {
                    return $bronzeDiff;
                }
            } elseif ($aStats && !$bStats) {
                return -1;
            } elseif (!$aStats && $bStats) {
                return 1;
            }

            return strcasecmp($aName, $bName);
        });
    }
    ?>
    <div class="modal fade" id="municipalityModal" tabindex="-1" role="dialog" aria-labelledby="municipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="municipalityModalLabel">Participating Teams</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size:1.4rem;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($allMunicipalities)): ?>
                        <div class="municipality-picker" id="municipalityPicker"
                            data-base-url="<?= $baseUrl; ?>" data-group-query="<?= $groupQuery; ?>">
                            <span class="municipality-picker-label">Jump to a team dashboard</span>
                            <div class="municipality-picker-row">
                                <select class="form-control form-control-sm" id="municipalitySelect">
                                    <option value="">Select team</option>
                                    <?php foreach ($allMunicipalities as $row): ?>
                                        <option value="<?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary btn-sm" id="municipalityViewButton">
                                    Details
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover winners-table">
                                <thead>
                                    <tr>
                                        <th>Team</th>
        <th class="text-center col-gold"><span class="medal-icon">🥇</span>Gold</th>
        <th class="text-center col-silver"><span class="medal-icon">🥈</span>Silver</th>
        <th class="text-center col-bronze"><span class="medal-icon">🥉</span>Bronze</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sortedMunicipalities as $row): ?>
                                        <?php
                                        $mName = $row->municipality;
                                        $logo = isset($row->logo) ? $row->logo : '';
                                        $mKey = $normalizeName($mName);
                                        $stats = isset($tallyMap[$mKey]) ? $tallyMap[$mKey] : null;
                                        $hasData = $stats && ((int) $stats->total_medals > 0 || (int) $stats->gold > 0 || (int) $stats->silver > 0 || (int) $stats->bronze > 0);
                                        $filterUrl = $baseUrl . '?municipality=' . urlencode($mName) . $groupQuery;
                                        ?>
                                        <?php
                                        $goldCls = ($hasData && (int)$stats->gold > 0) ? ' col-gold' : '';
                                        $silverCls = ($hasData && (int)$stats->silver > 0) ? ' col-silver' : '';
                                        $bronzeCls = ($hasData && (int)$stats->bronze > 0) ? ' col-bronze' : '';
                                        ?>
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center" style="gap:10px;">
                                                    <?php if (!empty($logo)): ?>
                                                        <img src="<?= base_url('upload/team_logos/' . $logo); ?>" alt="<?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?> logo" class="team-logo">
                                                    <?php endif; ?>
                                                    <span><?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center font-weight-bold<?= $goldCls; ?>"><?= $hasData ? (int) $stats->gold : '—'; ?></td>
                                            <td class="text-center font-weight-bold<?= $silverCls; ?>"><?= $hasData ? (int) $stats->silver : '—'; ?></td>
                                            <td class="text-center font-weight-bold<?= $bronzeCls; ?>"><?= $hasData ? (int) $stats->bronze : '—'; ?></td>
                                            <td class="text-center"><?= $hasData ? (int) $stats->total_medals : '—'; ?></td>
                                            <td class="text-right">
                                                <?php if ($hasData): ?>
                                                    <a href="<?= $filterUrl; ?>" class="btn btn-sm btn-outline-primary">
                                                        Details
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">No data yet</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-3">No municipalities recorded yet.</div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

        <!-- Events Recorded Modal -->
        <div class="modal fade" id="eventsRecordedModal" tabindex="-1" role="dialog" aria-labelledby="eventsRecordedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventsRecordedModalLabel">Events with Posted Results</h5>
                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size:1.4rem;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($eventSummaries)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th class="text-center">Group</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center col-gold"><span class="medal-icon">🥇</span>Gold</th>
                                            <th class="text-center col-silver"><span class="medal-icon">🥈</span>Silver</th>
                                            <th class="text-center col-bronze"><span class="medal-icon">🥉</span>Bronze</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($eventSummaries as $ev): ?>
                                            <?php
                                            $gold = (int) $ev['gold'];
                                            $silver = (int) $ev['silver'];
                                            $bronze = (int) $ev['bronze'];
                                            $total = $gold + $silver + $bronze;
                                            $goldCls = $gold > 0 ? ' col-gold' : '';
                                            $silverCls = $silver > 0 ? ' col-silver' : '';
                                            $bronzeCls = $bronze > 0 ? ' col-bronze' : '';
                                            $rowCls = $total > 0 ? ' class="has-medal-row"' : '';
                                            $goldTeams = !empty($ev['gold_teams']) ? implode(', ', $ev['gold_teams']) : '—';
                                            $silverTeams = !empty($ev['silver_teams']) ? implode(', ', $ev['silver_teams']) : '—';
                                            $bronzeTeams = !empty($ev['bronze_teams']) ? implode(', ', $ev['bronze_teams']) : '—';
                                            ?>
                                            <tr<?= $rowCls; ?>>
                                                <td><?= htmlspecialchars($ev['event_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center"><?= htmlspecialchars($ev['event_group'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center"><?= htmlspecialchars($ev['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold<?= $goldCls; ?>"><?= htmlspecialchars($goldTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold<?= $silverCls; ?>"><?= htmlspecialchars($silverTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center font-weight-bold<?= $bronzeCls; ?>"><?= htmlspecialchars($bronzeTeams, ENT_QUOTES, 'UTF-8'); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">No events with results yet.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\\/script>');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const ACTIVE_MUNICIPALITY = <?= json_encode($activeMunicipality); ?>;
        window.ALL_MUNICIPALITIES = <?= json_encode(array_values(array_map(function ($mun) {
                                        return isset($mun->municipality) ? trim($mun->municipality) : '';
                                    }, isset($sortedMunicipalities) && is_array($sortedMunicipalities) ? $sortedMunicipalities : array()))); ?>;
        (function($, bootstrap) {
            if (!$) {
                console.error('jQuery did not load; municipal modal and live updates are disabled.');
                return;
            }

            function normalizeKey(val) {
                return (val || '').trim().toLowerCase();
            }

            function formatDateTime(dtString) {
                if (!dtString) return 'No data yet';
                var d = new Date(dtString.replace(' ', 'T'));
                if (isNaN(d.getTime())) return dtString;
                var options = {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return d.toLocaleString(undefined, options);
            }

            var eventsPanelWasVisible = false;

            function openMunicipalityModal() {
                var modalEl = document.getElementById('municipalityModal');
                if (!modalEl) return;

                if ($.fn && $.fn.modal) {
                    $(modalEl).modal('show');
                    return;
                }

                if (bootstrap && bootstrap.Modal) {
                    var instance = bootstrap.Modal.getOrCreateInstance ?
                        bootstrap.Modal.getOrCreateInstance(modalEl) :
                        new bootstrap.Modal(modalEl);
                    instance.show();
                    return;
                }

                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.removeAttribute('aria-hidden');
                modalEl.setAttribute('aria-modal', 'true');
            }

            function openEventsRecordedModal() {
                var modalEl = document.getElementById('eventsRecordedModal');
                if (!modalEl) return;

                if ($.fn && $.fn.modal) {
                    $(modalEl).modal('show');
                    return;
                }

                if (bootstrap && bootstrap.Modal) {
                    var instance = bootstrap.Modal.getOrCreateInstance ?
                        bootstrap.Modal.getOrCreateInstance(modalEl) :
                        new bootstrap.Modal(modalEl);
                    instance.show();
                    return;
                }

                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.removeAttribute('aria-hidden');
                modalEl.setAttribute('aria-modal', 'true');
            }

            function toggleMedalPanel(show) {
                var $panel = $('#medalBreakdownPanel');
                var $tally = $('#liveTallyWrapper');
                var $eventsPanel = $('#eventsRecordedPanel');
                if (!$panel.length) return;
                if (show) {
                    eventsPanelWasVisible = $eventsPanel.length && $eventsPanel.is(':visible');
                    if (eventsPanelWasVisible) {
                        $eventsPanel.hide();
                    }
                    if ($tally.length) $tally.hide();
                    $panel.stop(true, true).slideDown(160);
                    var top = $panel.offset().top - 80;
                    $('html, body').animate({
                        scrollTop: top
                    }, 200);
                } else {
                    $panel.stop(true, true).slideUp(140, function() {
                        if (eventsPanelWasVisible && $eventsPanel.length) {
                            $eventsPanel.show();
                        } else if ($tally.length) {
                            $tally.show();
                        }
                        eventsPanelWasVisible = false;
                    });
                }
            }

            function toggleEventsPanel(show) {
                var $panel = $('#eventsRecordedPanel');
                var $tally = $('#liveTallyWrapper');
                if (!$panel.length) return;
                if (show) {
                    if ($tally.length) $tally.hide();
                    $('#medalBreakdownPanel').hide();
                    $panel.stop(true, true).slideDown(160);
                    var top = $panel.offset().top - 80;
                    $('html, body').animate({
                        scrollTop: top
                    }, 200);
                } else {
                    $panel.stop(true, true).slideUp(140, function() {
                        if ($tally.length) $tally.show();
                    });
                }
            }

            function renderWinnersRows(winners) {
                var hasResults = winners && winners.length > 0;

                if (hasResults) {
                    var tallies = {};
                    var medalWeight = {
                        Gold: 3,
                        Silver: 2,
                        Bronze: 1
                    };

                    winners.forEach(function(row) {
                        var key = normalizeKey(row.municipality);
                        if (!key) return;
                        if (!tallies[key]) {
                            tallies[key] = {
                                gold: 0,
                                silver: 0,
                                bronze: 0,
                                total: 0
                            };
                        }
                        var medalLower = (row.medal || '').toLowerCase();
                        if (medalLower === 'gold') tallies[key].gold++;
                        else if (medalLower === 'silver') tallies[key].silver++;
                        else if (medalLower === 'bronze') tallies[key].bronze++;
                        tallies[key].total++;
                    });

                    var sortedWinners = winners.slice().sort(function(a, b) {
                        var aKey = normalizeKey(a.municipality);
                        var bKey = normalizeKey(b.municipality);
                        var aStats = tallies[aKey] || {
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            total: 0
                        };
                        var bStats = tallies[bKey] || {
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            total: 0
                        };

                        var diff = bStats.gold - aStats.gold;
                        if (diff !== 0) return diff;
                        diff = bStats.silver - aStats.silver;
                        if (diff !== 0) return diff;
                        diff = bStats.bronze - aStats.bronze;
                        if (diff !== 0) return diff;
                        diff = bStats.total - aStats.total;
                        if (diff !== 0) return diff;

                        var medalDiff = (medalWeight[b.medal] || 0) - (medalWeight[a.medal] || 0);
                        if (medalDiff !== 0) return medalDiff;

                        var aEvent = (a.event_name || '').toLowerCase();
                        var bEvent = (b.event_name || '').toLowerCase();
                        if (aEvent !== bEvent) return aEvent.localeCompare(bEvent);

                        var aGroup = (a.event_group || '').toLowerCase();
                        var bGroup = (b.event_group || '').toLowerCase();
                        if (aGroup !== bGroup) return aGroup.localeCompare(bGroup);

                        var aCat = (a.category || '').toLowerCase();
                        var bCat = (b.category || '').toLowerCase();
                        if (aCat !== bCat) return aCat.localeCompare(bCat);

                        var aName = (a.full_name || '').toLowerCase();
                        var bName = (b.full_name || '').toLowerCase();
                        return aName.localeCompare(bName);
                    });

                    var rows = '';
                    sortedWinners.forEach(function(row) {
                        var medal = row.medal || 'Silver';
                        var chipClass = 'chip-silver';
                        if (medal === 'Gold') chipClass = 'chip-gold';
                        else if (medal === 'Bronze') chipClass = 'chip-bronze';

                        rows += '<tr>' +
                            '<td class="align-middle">' + $('<div>').text(row.event_name || '').html() + '</td>' +
                            '<td class="align-middle" style="white-space:nowrap;">' + $('<div>').text(row.event_group || '').html() + '</td>' +
                            '<td class="align-middle" style="white-space:nowrap;">' + $('<div>').text(row.category || '-').html() + '</td>' +
                            '<td class="align-middle">' + $('<div>').text(row.full_name || '').html() + '</td>' +
                            '<td class="align-middle text-center">' +
                            '<span class="chip-medal ' + chipClass + '">' +
                            $('<div>').text(medal).html() +
                            '</span>' +
                            '</td>' +
                            '<td class="align-middle">' + $('<div>').text(row.municipality || '').html() + '</td>' +
                            '</tr>';
                    });
                    return rows;
                }

                var placeholders = [];
                if (Array.isArray(window.ALL_MUNICIPALITIES)) {
                    window.ALL_MUNICIPALITIES.forEach(function(name) {
                        if (!name) return;
                        placeholders.push(name);
                    });
                }

                if (placeholders.length === 0) {
                    return '<tr class="no-results-row">' +
                        '<td colspan="6" class="text-center py-5" style="color:#9ca3af;font-size:1.05rem;">' +
                        '🏅 No results are available yet. Please wait for the organizers to post the official list of winners.' +
                        '</td></tr>';
                }

                var rows = '';
                placeholders.forEach(function(name) {
                    rows += '<tr class="no-results-row">' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">No winners posted yet</td>' +
                        '<td class="align-middle text-center text-muted">—</td>' +
                        '<td class="align-middle">' + $('<div>').text(name).html() + '</td>' +
                        '</tr>';
                });

                return rows;
            }

            function renderEventSummaries(rows) {
                if (!rows || rows.length === 0) {
                    return '<tr class="no-results-row"><td colspan="6" class="text-center py-4 text-muted">No events with posted results yet.</td></tr>';
                }
                var summary = {};
                rows.forEach(function(r) {
                    var key = (r.event_id !== undefined && r.event_id !== null) ?
                        'id-' + r.event_id :
                        'name-' + ((r.event_name || '') + '|' + (r.event_group || '') + '|' + (r.category || '')).toLowerCase();
                    if (!summary[key]) {
                        summary[key] = {
                            event_name: r.event_name || 'Unknown Event',
                            event_group: r.event_group || '-',
                            category: r.category || '-',
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            teams: [],
                            goldTeams: [],
                            silverTeams: [],
                            bronzeTeams: []
                        };
                    }
                    var teamName = (r.municipality || '').trim();
                    if (teamName && summary[key].teams.indexOf(teamName) === -1) {
                        summary[key].teams.push(teamName);
                    }
                    var medal = (r.medal || '').toLowerCase();
                    if (medal === 'gold') {
                        summary[key].gold++;
                        if (teamName && summary[key].goldTeams.indexOf(teamName) === -1) {
                            summary[key].goldTeams.push(teamName);
                        }
                    } else if (medal === 'silver') {
                        summary[key].silver++;
                        if (teamName && summary[key].silverTeams.indexOf(teamName) === -1) {
                            summary[key].silverTeams.push(teamName);
                        }
                    } else if (medal === 'bronze') {
                        summary[key].bronze++;
                        if (teamName && summary[key].bronzeTeams.indexOf(teamName) === -1) {
                            summary[key].bronzeTeams.push(teamName);
                        }
                    }
                });
                var list = Object.values(summary).sort(function(a, b) {
                    return (a.event_name || '').localeCompare(b.event_name || '');
                });
                var html = '';
                list.forEach(function(ev) {
                    var total = ev.gold + ev.silver + ev.bronze;
                    var rowCls = total > 0 ? ' class="has-medal-row"' : '';
                    var goldCls = ev.gold > 0 ? ' col-gold' : '';
                    var silverCls = ev.silver > 0 ? ' col-silver' : '';
                    var bronzeCls = ev.bronze > 0 ? ' col-bronze' : '';
                    var goldTeams = (ev.goldTeams && ev.goldTeams.length) ? ev.goldTeams.join(', ') : '—';
                    var silverTeams = (ev.silverTeams && ev.silverTeams.length) ? ev.silverTeams.join(', ') : '—';
                    var bronzeTeams = (ev.bronzeTeams && ev.bronzeTeams.length) ? ev.bronzeTeams.join(', ') : '—';
                    html += '<tr' + rowCls + '>' +
                        '<td>' + $('<div>').text(ev.event_name).html() + '</td>' +
                        '<td class="text-center">' + $('<div>').text(ev.event_group).html() + '</td>' +
                        '<td class="text-center">' + $('<div>').text(ev.category).html() + '</td>' +
                        '<td class="text-center font-weight-bold' + goldCls + '">' + $('<div>').text(goldTeams).html() + '</td>' +
                        '<td class="text-center font-weight-bold' + silverCls + '">' + $('<div>').text(silverTeams).html() + '</td>' +
                        '<td class="text-center font-weight-bold' + bronzeCls + '">' + $('<div>').text(bronzeTeams).html() + '</td>' +
                        '</tr>';
                });
                return html || '<tr class="no-results-row"><td colspan="6" class="text-center py-4 text-muted">No events with posted results yet.</td></tr>';
            }

            function refreshResults() {
                if (ACTIVE_MUNICIPALITY) {
                    return; // do not override the focused team view with live refresh rows
                }
                var TEAM_COUNT = <?= $teamsTotal; ?>;

                $.getJSON('<?= site_url('provincial/live_results'); ?>', function(resp) {
                    if (!resp) return;

                    if (resp.overview) {
                        var o = resp.overview;
                        $('#stat-municipalities').text(TEAM_COUNT || o.municipalities || 0);
                        $('#stat-events').text(o.events || 0);

                        var gold = o.gold || 0;
                        var silver = o.silver || 0;
                        var bronze = o.bronze || 0;
                        var total = o.total_medals || (gold + silver + bronze);

                        $('#stat-total-medals').text(total);
                        $('#stat-medal-breakdown').text(
                            '(' + gold + 'G · ' + silver + 'S · ' + bronze + 'B)'
                        );
                        $('#stat-last-update').text(formatDateTime(o.last_update));
                    }

                    if (resp.winners) {
                        $('#winners-body').html(renderWinnersRows(resp.winners));
                        $('#eventsRecordedBody').html(renderEventSummaries(resp.winners));
                    }
                }).fail(function() {
                    // fail silently for now
                });
            }

            $(function() {
                $('.loader-wrapper').fadeOut(200);

                $('#municipalityCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openMunicipalityModal();
                    }
                });

                $('#eventsRecordedCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleEventsPanel(true);
                    }
                });

                $('#totalMedalsCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleMedalPanel(true);
                    }
                });

                $('#stat-medal-breakdown, #stat-total-medals').css('cursor', 'pointer').on('click', function(e) {
                    e.preventDefault();
                    toggleMedalPanel(true);
                });

                $('#hideMedalBreakdown').on('click', function(e) {
                    e.preventDefault();
                    toggleMedalPanel(false);
                });

                $('#hideEventsPanel').on('click', function(e) {
                    e.preventDefault();
                    toggleEventsPanel(false);
                });

                refreshResults();
                setInterval(refreshResults, 30000);

                var $picker = $('#municipalityPicker');
                if ($picker.length) {
                    var $select = $('#municipalitySelect');
                    var $viewBtn = $('#municipalityViewButton');

                    function goToMunicipality(municipality) {
                        if (!municipality) return;
                        var baseUrl = $picker.data('base-url') || '<?= site_url('provincial'); ?>';
                        var groupQuery = $picker.data('group-query') || '';
                        var url = baseUrl + '?municipality=' + encodeURIComponent(municipality) + groupQuery;
                        window.location.href = url;
                    }

                    $viewBtn.on('click', function() {
                        goToMunicipality($select.val());
                    });

                    // (optional) If you want changing the select to auto-jump, uncomment:
                    // $select.on('change', function() {
                    //     goToMunicipality($(this).val());
                    // });
                }
            });
        })(window.jQuery, window.bootstrap);

        // Medal filter on winners table: click totals to show rows with that medal; click again to reset.
        (function($) {
            var activeMedal = null;
            var $rows = $('#winners-body').find('tr');
            var $clearBtn = $('#clearMedalFilter');

            function applyMedalFilter() {
                if (!activeMedal) {
                    $rows.show();
                    return;
                }
                $rows.each(function() {
                    var medal = ($(this).data('medal') || '').toString();
                    $(this).toggle(medal === activeMedal);
                });
            }

            $('.medal-filter').on('click', function() {
                var medal = ($(this).data('medal') || '').toString();
                activeMedal = (activeMedal === medal) ? null : medal;
                applyMedalFilter();
            });

            if ($clearBtn.length) {
                $clearBtn.on('click', function() {
                    activeMedal = null;
                    applyMedalFilter();
                });
            }
        })(window.jQuery);
    </script>

</body>

</html>
