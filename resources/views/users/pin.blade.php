<x-layouts::app :title="__('Withdrawal Verification')">
    <style>
        .verify-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* background-color: #0f172a; */
            padding: 20px;
            font-family: 'Inter', sans-serif;
            /* color: #ffffff; */
        }

        .verify-card {
            width: 100%;
            max-width: 450px;
            /* background: #212f45; */
            border-radius: 20px;
            /* border: 1px solid #334155; */
            padding: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Progress Bar Styling */
        .progress-container {
            width: 100%;
            height: 6px;
            background: #0f172a;
            border-radius: 10px;
            margin: 20px 0 30px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            width: 0%;
            transition: width 0.1s linear;
        }

        /* Form Inputs */
        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-field {
            width: 100%;
            padding: 14px;
            /* background: #0f172a; */
            border: 1px solid #334155;
            border-radius: 10px;
            /* color: white; */
            font-size: 18px;
            letter-spacing: 4px;
            text-align: center;
            outline: none;
        }

        .input-field:focus {
            border-color: #3b82f6;
        }

        .btn-verify {
            width: 100%;
            padding: 16px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-verify:disabled {
            background: #334155;
            cursor: not-allowed;
        }

        [x-cloak] {
            display: none !important;
        }

        /* ================= MOBILE RESPONSIVENESS ================= */
        @media (max-width: 640px) {

            .verify-page {
                padding: 12px;
                align-items: flex-start;
                /* prevents vertical squeeze */
                /* min-height: 100dvh; */
                max-height: 100dvh;
                /* better mobile height handling */
            }

            .verify-card {
                max-width: 100%;
                padding: 20px;
                border-radius: 14px;
            }

            /* Progress Bar */
            .progress-container {
                height: 5px;
                margin: 16px 0 24px;
            }

            /* Inputs */
            .input-group {
                margin-bottom: 16px;
            }

            .input-label {
                font-size: 11px;
                margin-bottom: 6px;
            }

            .input-field {
                padding: 12px;
                font-size: 16px;
                letter-spacing: 3px;
                border-radius: 8px;
            }

            /* Button */
            .btn-verify {
                padding: 14px;
                font-size: 15px;
                border-radius: 8px;
            }
        }
    </style>

    <div class="verify-page" x-data="{
        step: 1,
        loading: false,
        progress: 0,
        codes: { tax: '', cot: '', token: '' },
    
        startProcessing() {
            this.loading = true;
            this.progress = 0;
            let interval = setInterval(() => {
                if (this.progress >= 100) {
                    clearInterval(interval);
                    this.loading = false;
                    this.step++;
                } else {
                    this.progress += 2; // Speed of progress bar
                }
            }, 50); // Adjust for faster/slower feel
        }
    }">

        <div class="verify-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="color: #3b82f6; font-weight: 800; font-size: 12px;">STEP <span x-text="step"></span> OF
                    3</span>
                <span x-show="loading" style="font-size: 12px; color: #60a5fa;">Processing...</span>
            </div>

            <div class="progress-container">
                <div class="progress-bar" :style="'width: ' + progress + '%'"></div>
            </div>

            <div x-show="step === 1 && !loading" x-transition x-cloak>
                <h2 style="margin: 0 0 10px;">Tax Verification</h2>
                <p style="color: #94a3b8; font-size: 14px; margin-bottom: 25px;">Please enter your government-issued Tax
                    Clearance Code to proceed.</p>

                <div class="input-group">
                    <label class="input-label">Tax Code</label>
                    <input type="text" x-model="codes.tax" maxlength="8" placeholder="********" class="input-field">
                </div>
                <button @click="startProcessing()" :disabled="!codes.tax" class="btn-verify">VERIFY TAX CODE</button>
            </div>

            <div x-show="step === 2 && !loading" x-transition x-cloak>
                <h2 style="margin: 0 0 10px;">COT Verification</h2>
                <p style="color: #94a3b8; font-size: 14px; margin-bottom: 25px;">Cost of Transfer (COT) clearance is
                    required for international settlements.</p>

                <div class="input-group">
                    <label class="input-label">COT Code</label>
                    <input type="text" x-model="codes.cot" maxlength="8" placeholder="********" class="input-field">
                </div>
                <button @click="startProcessing()" :disabled="!codes.cot" class="btn-verify">VERIFY COT CODE</button>
            </div>

            <div x-show="step === 3 && !loading" x-transition x-cloak>
                <h2 style="margin: 0 0 10px;">Token Finalization</h2>
                <p style="color: #94a3b8; font-size: 14px; margin-bottom: 25px;">Final security token generated by your
                    account manager.</p>

                <div class="input-group">
                    <label class="input-label">Token Code</label>
                    <input type="text" x-model="codes.token" maxlength="8" placeholder="********"
                        class="input-field">
                </div>
                <button @click="startProcessing()" :disabled="!codes.token" class="btn-verify">COMPLETE
                    WITHDRAWAL</button>
            </div>

            <div x-show="loading" style="text-align: center; padding: 40px 0;" x-cloak>
                <div style="font-size: 40px; margin-bottom: 20px;">⚙️</div>
                <h3 style="margin-bottom: 5px;">Synchronizing...</h3>
                <p style="color: #64748b; font-size: 13px;">Checking secure database for code validity</p>
            </div>

            <div x-show="step === 4" style="text-align: center;" x-cloak>
                <div style="color: #10b981; font-size: 60px; margin-bottom: 20px;">✓</div>
                <h2>Approved!</h2>
                <p style="color: #94a3b8; margin-bottom: 25px;">Your verification is complete. Funds are being
                    disbursed.</p>
                <a href="/dashboard" class="btn-verify" style="display: block; text-decoration: none;">RETURN TO
                    DASHBOARD</a>
            </div>

        </div>
    </div>
</x-layouts::app>
