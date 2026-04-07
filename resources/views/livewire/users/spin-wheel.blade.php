<div>
    <style>
        /* 🌌 BODY */
        body {
            margin: 0;
            /* background: radial-gradient(circle at center, #0f172a, #020617); */
            font-family: 'Segoe UI', sans-serif;
        }


        .game-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }


        /* 🌌 BALANCE DISPLAY STYLES */
        .balance-header {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
            z-index: 100;
        }

        .balance-item {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .balance-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            font-weight: 700;
        }

        .balance-amount {
            font-family: 'monospace';
            font-weight: 900;
            color: #22c55e;
            font-size: 1.1rem;
        }

        /* 🎮 GAME CONTAINER */
        /* .game-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        } */

        /* 🎡 WHEEL WRAPPER */
        .wheel-wrapper {
            position: relative;
            width: 90vw;
            max-width: 320px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: radial-gradient(circle, #1e293b, #020617);
            box-shadow:
                0 0 40px rgba(0, 0, 0, 0.8),
                inset 0 0 15px rgba(255, 255, 255, 0.05);
            border: 8px solid #111827;
            overflow: visible;
        }

        /* 🎯 POINTER */
        .pin {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 50px;
            z-index: 20;
            filter: drop-shadow(0 5px 8px rgba(0, 0, 0, 0.6));
        }

        /* 🎡 SVG WHEEL */
        #wheel-svg {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            transition: transform 5s cubic-bezier(0.15, 0, 0.2, 1);
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.6);
        }

        /* 🎯 CENTER HUB */
        .center-hub {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: radial-gradient(circle, #facc15, #ca8a04);
            border-radius: 50%;
            z-index: 10;
            box-shadow: 0 0 15px rgba(250, 204, 21, 0.8);
        }

        /* 🔥 SPIN BUTTON */
        .spin-trigger {
            margin-top: 30px;
            padding: 12px 40px;
            font-size: 18px;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 6px 0 #7f1d1d, 0 12px 20px rgba(0, 0, 0, 0.4);
            transition: all 0.2s;
        }

        .spin-trigger:active {
            transform: translateY(4px);
            box-shadow: 0 3px 0 #7f1d1d;
        }

        .spin-trigger:disabled {
            background: #475569;
            cursor: not-allowed;
        }

        /* 🎉 MODAL */
        /* 🎉 PREMIUM WIN MODAL */
        #winModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, 0.9);
            /* Deep Navy backdrop */
            backdrop-filter: blur(12px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
            transition: all 0.4s ease;
        }

        .win-content {
            background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            border-radius: 32px;
            padding: 40px 24px;
            text-align: center;
            position: relative;
            max-width: 420px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 40px rgba(234, 179, 8, 0.1);
            /* Subtle Golden Glow */
            animation: premiumPopup 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* 🖼️ PRIZE IMAGE SLOT */
        .prize-display {
            width: 100%;
            height: 180px;
            background: #000;
            border-radius: 20px;
            margin: 20px 0;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.8);
        }

        .prize-display img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }

        /* 🏷️ TEXT STYLING */
        #statusText {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.4em;
            color: #94a3b8;
            /* Muted Slate */
            margin-bottom: 8px;
            font-weight: 600;
        }

        #prizeText {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 900;
            background: linear-gradient(to bottom, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        /* ⚡ PREMIUM BUTTON */
        .win-content button {
            width: 100%;
            margin-top: 20px;
            padding: 16px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #020617;
            background: linear-gradient(90deg, #facc15, #eab308);
            /* Gold Gradient */
            border: none;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(234, 179, 8, 0.3);
            transition: all 0.3s ease;
        }

        .win-content button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -3px rgba(234, 179, 8, 0.4);
            filter: brightness(1.1);
        }

        .win-content button:active {
            transform: translateY(0);
        }

        /* ✨ ANIMATION */
        @keyframes premiumPopup {
            0% {
                transform: scale(0.7) translateY(40px);
                opacity: 0;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        /* Loss Variant Styles */
        .is-loss #statusText {
            color: #ef4444;
        }

        .is-loss #prizeText {
            background: linear-gradient(to bottom, #fca5a5, #ef4444);
            -webkit-background-clip: text;
        }

        .is-loss button {
            background: #1e293b;
            color: #94a3b8;
            box-shadow: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes popupFade {
            from {
                transform: scale(0.7);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* 📱 RESPONSIVE TEXT */
        @media (max-width: 500px) {
            .game-container {
                min-height: 80vh;
            }

            .spin-trigger {
                font-size: 16px;
                padding: 10px 25px;
            }

            .win-content h1 {
                font-size: 1.6rem;
            }

            .win-content h3 {
                font-size: 1.2rem;
            }

            .balance-header {
                top: 10px;
                right: 10px;
            }

            .balance-item {
                padding: 6px 12px;
            }

            .balance-label {
                font-size: 8px;
            }

            .balance-amount {
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="game-container">
        <div class="balance-header">
            <div class="balance-item">
                <span class="balance-label">Cash</span>
                <span class="balance-amount">${{ number_format(auth()->user()->wallet->balance, 2) }}</span>
            </div>
            <div class="balance-item">
                <span class="balance-label">Assets</span>
                <span class="balance-amount">{{ number_format(auth()->user()->wallet->tesla_balance, 0) }}</span>
            </div>
        </div>


        <div class="wheel-wrapper">

            <!-- 🎯 POINTER -->
            <svg class="pin" viewBox="0 0 30 40">
                <path d="M15 40 L30 0 L0 0 Z" fill="#facc15" />
            </svg>

            <!-- 🎡 WHEEL -->
            <svg id="wheel-svg" viewBox="0 0 100 100" wire:ignore>
                <g id="wheel-group"></g>
            </svg>

            <!-- 🎯 CENTER -->
            <div class="center-hub"></div>

            <!-- Tick sound -->
            <audio id="tick-sound"
                src="https://orangefreesounds.com/wp-content/uploads/2025/11/Prize-wheel-spin-sound-effect.mp3"
                preload="auto">
            </audio>

        </div>

        @if ($canSpin)
            <button class="spin-trigger" wire:click="spin" wire:loading.attr="disabled" @disabled(!$canSpin)>
                SPIN NOW
            </button>
            <span class="mt-4 text-sm text-gray-500">
                You have {{ $remainingSpins }} spins left
            </span>
        @else
            <button class="spin-trigger" disabled>
                NO SPINS LEFT
            </button>
            <span class="mt-4 text-sm text-gray-500">
                You have {{ $remainingSpins }} spins left
            </span>
        @endif
    </div>

    <!-- 🎉 MODAL -->
    <div id="winModal">
        <div class="win-content" id="modalContainer">
            <h3 id="statusText">Result</h3>
            <h1 id="prizeText">---</h1>
            <button onclick="closeModal()">Collect Reward</button>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {

            const prizes = [{
                    label: "TESLA CAR",
                    color: "#ef4444",
                    icon: "🚗",
                    amount: 1
                },
                {
                    label: "$10,000",
                    color: "#facc15",
                    icon: "💰",
                    amount: 10000
                },
                {
                    label: "$100,000",
                    color: "#22c55e",
                    icon: "💎",
                    amount: 100000
                },
                {
                    label: "LOSE",
                    color: "#6b21a8",
                    icon: "❌",
                    amount: 0
                },
                {
                    label: "$60,000",
                    color: "#3b82f6",
                    icon: "💵",
                    amount: 60000
                },
            ];

            const wheelGroup = document.getElementById('wheel-group');
            const wheelSvg = document.getElementById('wheel-svg');

            let currentRotation = 0;
            const angle = 360 / prizes.length;

            // 🎡 DRAW WHEEL SLICES
            prizes.forEach((prize, i) => {
                const start = i * angle;
                const end = (i + 1) * angle;

                const x1 = 50 + 50 * Math.cos((start - 90) * Math.PI / 180);
                const y1 = 50 + 50 * Math.sin((start - 90) * Math.PI / 180);
                const x2 = 50 + 50 * Math.cos((end - 90) * Math.PI / 180);
                const y2 = 50 + 50 * Math.sin((end - 90) * Math.PI / 180);

                const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                path.setAttribute("d", `M50 50 L${x1} ${y1} A50 50 0 0 1 ${x2} ${y2} Z`);
                path.setAttribute("fill", prize.color);
                path.setAttribute("stroke", "#020617");
                path.setAttribute("stroke-width", "0.8");
                wheelGroup.appendChild(path);

                const group = document.createElementNS("http://www.w3.org/2000/svg", "g");
                const rot = start + angle / 2;
                group.setAttribute("transform", `rotate(${rot},50,50)`);

                const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                text.setAttribute("x", "50");
                text.setAttribute("y", "20");
                text.setAttribute("fill", "#fff");
                text.setAttribute("font-size", "4");
                text.setAttribute("text-anchor", "middle");
                text.setAttribute("dominant-baseline", "middle");
                text.textContent = prize.label;

                const icon = document.createElementNS("http://www.w3.org/2000/svg", "text");
                icon.setAttribute("x", "50");
                icon.setAttribute("y", "28");
                icon.setAttribute("font-size", "8");
                icon.setAttribute("text-anchor", "middle");
                icon.textContent = prize.icon;

                group.appendChild(text);
                group.appendChild(icon);
                wheelGroup.appendChild(group);
            });

            
            // 🎯 SPIN LOGIC
            window.addEventListener('spinResult', (event) => {
                const data = event.detail;
                const index = Number(data.index);

                // 🚨 HARD VALIDATION
                if (isNaN(index) || index < 0 || index >= prizes.length) {
                    console.error("Invalid index from backend:", data);
                    return;
                }

                const targetAngle = index * angle + angle / 2;
                const rotation = 3600 + (360 - targetAngle); // 10 full spins + land

                // ⚡ RESET WHEEL BEFORE SPIN
                wheelSvg.style.transition = "none";
                wheelSvg.style.transform = `rotate(0deg)`;
                wheelSvg.offsetHeight; // force reflow

                const tickAudio = document.getElementById('tick-sound');

                // 🎡 Start animation
                wheelSvg.style.transition = "transform 5s cubic-bezier(0.15, 0, 0.2, 1)";
                wheelSvg.style.transform = `rotate(${rotation}deg)`;

                // 🕹 Simulate tick sound along spin
                const totalTicks = 40; // increase for more casino feel
                let tickCount = 0;

                const tickInterval = setInterval(() => {
                    if (tickCount >= totalTicks) {
                        clearInterval(tickInterval);
                        return;
                    }

                    tickAudio.currentTime = 0;
                    tickAudio.play();
                    tickCount++;
                }, 3000 / totalTicks); // spread ticks across spin duration (5s)

                // Show result after spin
                setTimeout(() => showResult(data), 5000);
            });
        });

        function showResult(data) {
            const modal = document.getElementById('winModal');
            const prizeText = document.getElementById('prizeText');
            const statusText = document.getElementById('statusText');

            statusText.innerText = data.label === "LOSE" ? "OOH NO!" : "CONGRATS!";
            prizeText.innerText = data.label;

            modal.style.display = "flex";
        }

        function closeModal() {
            document.getElementById('winModal').style.display = "none";
            @this.refreshWheel();
        }
    </script>
</div>
