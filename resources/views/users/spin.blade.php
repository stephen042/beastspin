<x-layouts::app :title="__('SPIN TO WIN')">
    <style>
        :root {
            --wheel-size: 400px;
        }

        @media (max-width: 500px) {
            :root {
                --wheel-size: 350px;
            }
        }

        .game-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
            /* background: radial-gradient(circle, #2c3e50 0%, #000000 100%); */
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* 1. Ensure the wrapper has a lower stacking order than the sidebar */
        .wheel-wrapper {
            position: relative;
            width: var(--wheel-size);
            height: var(--wheel-size);
            padding: 20px;
            background: #1a1a1a;
            border-radius: 50%;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(255, 255, 255, 0.1);
            border: 10px solid #333;
            /* ADD THIS: Forces all children (pin/hub) to stay inside this layer */
            z-index: 1;
        }

        /* 2. Update the Pin z-index to be relative to the wrapper */
        .pin {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 50px;
            /* Lower this so it doesn't fight the sidebar's 1000+ z-index */
            z-index: 10;
            filter: drop-shadow(0 5px 5px rgba(0, 0, 0, 0.5));
            transition: transform 0.1s;
        }

        /* 3. Update the Center Hub z-index */
        .center-hub {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: #fff;
            border-radius: 50%;
            /* Ensure it's above the SVG but below the sidebar */
            z-index: 5;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        #wheel-svg {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.8);
            transition: transform 5s cubic-bezier(0.15, 0, 0.2, 1);
            will-change: transform;
        }

        /* Center Button Decoration */
        /* .center-hub {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: #fff;
            border-radius: 50%;
            z-index: 30;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        } */

        /* Spin Button Styling */
        .spin-trigger {
            margin-top: 40px;
            padding: 15px 50px;
            font-size: 24px;
            font-weight: 900;
            color: white;
            background: linear-gradient(to bottom, #e74c3c, #c0392b);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 8px 0 #922b21, 0 15px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.1s;
        }

        .spin-trigger:active {
            transform: translateY(4px);
            box-shadow: 0 4px 0 #922b21, 0 8px 10px rgba(0, 0, 0, 0.3);
        }

        .spin-trigger:disabled {
            background: #7f8c8d;
            box-shadow: 0 4px 0 #2c3e50;
            cursor: not-allowed;
        }

        /* Modern Flux Modal */
        #winModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(8px);
        }

        .win-content {
            background: #1e293b;
            border: 1px solid #334155;
            padding: 48px;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
        }

        .modal-btn {
            background: white;
            color: black;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-top: 24px;
        }

        @keyframes popIn {
            to {
                transform: scale(1);
            }
        }
    </style>

    <div class="game-container">
        <div class="wheel-wrapper">
            <svg class="pin" viewBox="0 0 30 40">
                <path d="M15 40 L30 0 L0 0 Z" fill="#f1c40f" />
            </svg>

            <svg id="wheel-svg" viewBox="0 0 100 100">
                <g id="wheel-group"></g>
            </svg>

            <div class="center-hub">
                <div style="width:40px; height:40px; background:#444; border-radius:50%"></div>
            </div>
        </div>

        <button class="spin-trigger" id="spinBtn" onclick="spin()">SPIN NOW</button>
    </div>


    <div id="winModal">
        <div class="win-content">
            <h3 id="statusText"
                style="color:#94a3b8; margin:0; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em;">
                Result</h3>
            <h1 id="prizeText" style="font-size: 2.5rem; margin: 16px 0; font-weight: 800;">---</h1>
            <button class="modal-btn" onclick="closeModal()">Continue</button>
        </div>
    </div>

    <script>
        const wheelGroup = document.getElementById('wheel-group');
        const wheelSvg = document.getElementById('wheel-svg');
        const spinBtn = document.getElementById('spinBtn');

        const prizes = [{
                label: "TESLA CAR",
                color: "#e74c3c",
                value: "🚗"
            },
            {
                label: "LOSE",
                color: "#34495e",
                value: "❌"
            },
            {
                label: "$10,000",
                color: "#f1c40f",
                value: "💰"
            },
            {
                label: "$100,000",
                color: "#2ecc71",
                value: "💎"
            },
            {
                label: "LOSE",
                color: "#9b59b6",
                value: "❌"
            },
            {
                label: "$60,000",
                color: "#3498db",
                value: "💵"
            },
            {
                label: "LOSE",
                color: "#7f8c8d",
                value: "❌"
            }
        ];

        const numPrizes = prizes.length;
        const anglePerSlice = 360 / numPrizes;

        // Create SVG Slices
        prizes.forEach((prize, i) => {
            const startAngle = i * anglePerSlice;
            const endAngle = (i + 1) * anglePerSlice;

            // Math for SVG Arc
            const x1 = 50 + 50 * Math.cos(Math.PI * (startAngle - 90) / 180);
            const y1 = 50 + 50 * Math.sin(Math.PI * (startAngle - 90) / 180);
            const x2 = 50 + 50 * Math.cos(Math.PI * (endAngle - 90) / 180);
            const y2 = 50 + 50 * Math.sin(Math.PI * (endAngle - 90) / 180);

            const pathData = `M 50 50 L ${x1} ${y1} A 50 50 0 0 1 ${x2} ${y2} Z`;

            // Slice Path
            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", pathData);
            path.setAttribute("fill", prize.color);
            path.setAttribute("stroke", "#fff");
            path.setAttribute("stroke-width", "0.5");
            wheelGroup.appendChild(path);

            // Text Group (Label + Icon)
            const textGroup = document.createElementNS("http://www.w3.org/2000/svg", "g");
            const rotation = startAngle + (anglePerSlice / 2);
            textGroup.setAttribute("transform", `rotate(${rotation}, 50, 50)`);

            const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
            text.setAttribute("x", "50");
            text.setAttribute("y", "15");
            text.setAttribute("fill", "white");
            text.setAttribute("font-size", "4");
            text.setAttribute("font-weight", "bold");
            text.setAttribute("text-anchor", "middle");
            text.setAttribute("transform", "rotate(0, 50, 20)");
            text.textContent = prize.label;

            const icon = document.createElementNS("http://www.w3.org/2000/svg", "text");
            icon.setAttribute("x", "50");
            icon.setAttribute("y", "25");
            icon.setAttribute("font-size", "8");
            icon.setAttribute("text-anchor", "middle");
            icon.textContent = prize.value;

            textGroup.appendChild(text);
            textGroup.appendChild(icon);
            wheelGroup.appendChild(textGroup);
        });

        let currentRotation = 0;

        function spin() {
            if (spinBtn.disabled) return;
            spinBtn.disabled = true;

            const winningIndex = Math.floor(Math.random() * numPrizes);

            // Calculate exact center of the slice to avoid landing on lines
            const centerOfSlice = (anglePerSlice / 2);
            const targetSliceRotation = (winningIndex * anglePerSlice) + centerOfSlice;

            // Add 10 full rotations (3600deg) + offset to land index at top (0deg)
            // We subtract targetSliceRotation because wheel spins clockwise
            const extraSpins = 3600;
            const totalRotation = extraSpins + (360 - targetSliceRotation);

            currentRotation += totalRotation;
            wheelSvg.style.transform = `rotate(${currentRotation}deg)`;

            setTimeout(() => {
                showResult(prizes[winningIndex]);
                spinBtn.disabled = false;
            }, 5000);
        }

        function showResult(prize) {
            const modal = document.getElementById('winModal');
            const prizeText = document.getElementById('prizeText');
            const statusText = document.getElementById('statusText');

            statusText.innerText = prize.label === "LOSE" ? "OOH NO!" : "CONGRATULATIONS!";
            prizeText.innerText = prize.label;
            prizeText.style.color = prize.label === "LOSE" ? "#e74c3c" : "#27ae60";

            modal.style.display = "flex";
        }

        function closeModal() {
            document.getElementById('winModal').style.display = "none";
        }
    </script>
</x-layouts::app>
