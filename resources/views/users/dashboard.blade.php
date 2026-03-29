<x-layouts::app :title="__('Dashboard')">
    <div class="dashboard-layout">

        <div class="stats-container bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 shadow-sm">
            <div class="stats-grid">
                <div class="stat-item border-b md:border-b-0 md:border-r border-zinc-100 dark:border-white/5">
                    <div class="stat-meta">
                        <span class="label text-orange-500">Total Portfolio</span>
                        <h3 class="value text-zinc-900 dark:text-white">$124,500.00</h3>
                        <p class="sub-text text-zinc-500">Available for withdrawal</p>
                    </div>
                    <div class="icon-box bg-orange-500/10 text-orange-500">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>

                <div class="stat-item relative">
                    <div class="stat-meta relative z-10">
                        <span class="label text-zinc-500">Fleet Status</span>
                        <h3 class="value text-zinc-900 dark:text-white">2 <span
                                class="text-sm opacity-50 font-normal">Cars</span></h3>
                    </div>
                    <div class="car-anchor">
                        <img src="{{ asset('assets/images/beastimages/tesla.jpg') }}" alt="Tesla"
                            class="car-img opacity-40 dark:opacity-20">
                    </div>
                </div>
            </div>
        </div>

        <div class="action-section">
            <a href="{{ route('spin') }}"
                class="spin-banner bg-orange-500 hover:bg-orange-600 text-white shadow-lg shadow-orange-500/20">
                <div class="banner-content">
                    <i class="fas fa-dharmachakra wheel-spin"></i>
                    <div class="text-group">
                        <h2 class="text-3xl md:text-5xl font-black italic tracking-tighter">SPIN NOW</h2>
                        <p class="text-[10px] font-bold tracking-[0.4em] uppercase opacity-80">Win Instant Rewards</p>
                    </div>
                    <i class="fas fa-bolt text-yellow-300 animate-pulse hidden md:block"></i>
                </div>
            </a>
        </div>

        <div class="history-card bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 shadow-sm">
            <div class="card-header border-b border-zinc-100 dark:border-white/5">
                <div class="title-group">
                    <h4 class="text-zinc-900 dark:text-white font-bold uppercase tracking-tight">Recent Activity</h4>
                    <p class="text-xs text-zinc-500 italic">Live results</p>
                </div>
                <a href="{{ route('withdraw') }}"
                    class="withdraw-btn border border-orange-500/50 text-orange-500 hover:bg-orange-500 hover:text-white transition-all">
                    WITHDRAW
                </a>
            </div>

            <div class="table-wrapper overflow-x-auto" style="padding: 5px;">
                <table class="w-full" style="border-spacing: 0 12px; border-collapse: separate;">
                    <thead>
                        <tr
                            style="color: #a1a1aa; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em;">
                            <th style="padding: 10px 24px; text-align: left;">Timestamp</th>
                            <th style="padding: 10px 24px; text-align: left;">Event</th>
                            <th style="padding: 10px 24px; text-align: center;">Asset Preview</th>
                            <th style="padding: 10px 24px; text-align: right;">Net Profit</th>
                        </tr>
                    </thead>

                    <tbody style="color: inherit;">
                        <tr class="group transition-all duration-300 hover:translate-y-[-2px]"
                            style="background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); box-shadow: 0 4px 20px rgba(0,0,0,0.1);border-radius: 16px;">

                            <td
                                style="padding: 20px 24px; border-radius: 16px 0 0 16px; border: 1px solid rgba(255,255,255,0.05); border-right: none;">
                                <div style="font-size: 13px; font-weight: 600;">Mar 29, 2026</div>
                                <div style="font-size: 10px; opacity: 0.5; margin-top: 4px;">14:30 GMT+1</div>
                            </td>

                            <td
                                style="padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <span
                                    style="background: linear-gradient(90deg, #f59e0b, #ea580c); color: white; padding: 4px 12px; border-radius: 8px; font-size: 9px; font-weight: 900; letter-spacing: 0.05em; display: inline-block; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);">
                                    TESLA UNLOCKED
                                </span>
                            </td>

                            <td
                                style="padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                <div class="relative group-hover:scale-110 transition-transform duration-500"
                                    style="width: 100px; height: 50px; margin: 0 auto; border-radius: 10px; overflow: hidden; background: #000;  box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);">
                                    <img src="{{ asset('assets/images/beastimages/tesla.jpg') }}"
                                        style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;">
                                </div>
                            </td>

                            <td
                                style="padding: 20px 24px; border-radius: 0 16px 16px 0; border: 1px solid rgba(255,255,255,0.05); border-left: none; text-align: right;">
                                <div
                                    style="font-size: 18px; font-weight: 900; color: #22c55e; letter-spacing: -0.02em;">
                                    JACKPOT</div>
                                <div style="font-size: 10px; opacity: 0.6;">Asset Value: $42,990</div>
                            </td>
                        </tr>

                        <tr class="transition-all duration-300 hover:bg-white/[0.02]" style="background: transparent;">
                            <td style="padding: 20px 24px; border-radius: 16px 0 0 16px;">
                                <div style="font-size: 13px; font-weight: 600;">Mar 29, 2026</div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <span
                                    style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 4px 12px; border-radius: 8px; font-size: 9px; font-weight: 900; border: 1px solid rgba(34, 197, 94, 0.2);">
                                    CASH WIN
                                </span>
                            </td>

                            <td
                                style="padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                <div class="relative group-hover:scale-110 transition-transform duration-500"
                                    style="width: 100px; height: 50px; margin: 0 auto; border-radius: 10px; overflow: hidden; background: #000;  box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);">
                                    <img src="{{ asset('assets/images/beastimages/cash.jpg') }}"
                                        style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;">
                                </div>
                            </td>

                            <td style="padding: 20px 24px; border-radius: 0 16px 16px 0; text-align: right;">
                                <div style="font-size: 16px; font-weight: 800; color: #22c55e;">+$10,000.00</div>
                            </td>
                        </tr>

                        <tr class="transition-all duration-300 hover:bg-white/[0.02]" style="background: transparent;">
                            <td style="padding: 20px 24px; border-radius: 16px 0 0 16px; opacity: 0.5;">
                                <div style="font-size: 13px;">Mar 28, 2026</div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <span
                                    style="background: rgba(161, 161, 170, 0.1); color: #a1a1aa; padding: 4px 12px; border-radius: 8px; font-size: 9px; font-weight: 900;">
                                    LOSS
                                </span>
                            </td>

                            <td
                                style="padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                <div class="relative group-hover:scale-110 transition-transform duration-500"
                                    style="width: 100px; height: 50px; margin: 0 auto; border-radius: 10px; overflow: hidden; background: #000;  box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);">
                                    <img src="{{ asset('assets/images/beastimages/lostcash.jpg') }}"
                                        style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;">
                                </div>
                            </td>

                            <td style="padding: 20px 24px; border-radius: 0 16px 16px 0; text-align: right;">
                                <div style="font-size: 16px; font-weight: 800; color: #ef4444; opacity: 0.8;">-$500.00
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts::app>

<style>
    /* LAYOUT & SPACING (No text/bg colors here to respect Flux) */
    .dashboard-layout {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 1rem;
        max-width: 80rem;
        margin: 0 auto;
    }

    /* Stats Section */
    .stats-container {
        border-radius: 1.5rem;
        overflow: hidden;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .stat-item {
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .value {
        font-size: 2.25rem;
        font-weight: 900;
        line-height: 1;
        margin: 0.5rem 0;
    }

    .icon-box {
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        font-size: 1.5rem;
    }

    .car-anchor {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 12rem;
        pointer-events: none;
    }

    .car-img {
        width: 100%;
        object-fit: contain;
        transform: translate(15%, 15%);
        transition: transform 0.5s ease;
    }

    .stat-item:hover .car-img {
        transform: translate(0, 0) scale(1.05);
    }

    /* Spin Banner */
    .spin-banner {
        display: block;
        padding: 1.5rem 1rem;
        border-radius: 1.5rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .banner-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
    }

    .wheel-spin {
        font-size: 3rem;
        animation: spin-anim 12s linear infinite;
    }

    /* Table & History */
    .history-card {
        border-radius: 1.5rem;
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .withdraw-btn {
        padding: 0.5rem 1.25rem;
        border-radius: 0.75rem;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .win-badge {
        padding: 0.25rem 0.6rem;
        border-radius: 0.375rem;
        font-size: 0.65rem;
        font-weight: 900;
    }

    @keyframes spin-anim {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>