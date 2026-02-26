{{-- Morse Code Converter --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-tools me-2"></i>
    Morse Code Converter tool for encoding and decoding text to/from Morse code.
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-radio me-3"></i>Morse Code Converter
                </h1>
                <p class="lead text-muted">
                    Convert text to Morse code and vice versa
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Morse Code Encoder/Decoder</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="textInput" class="form-label fw-semibold">
                            <i class="fas fa-edit me-2"></i>Input
                        </label>
                        <textarea class="form-control" id="textInput" rows="4"
                            placeholder="Enter text to convert to Morse code, or Morse code to convert to text..."
                            style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;"></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            For Morse code input, use dots (.) and dashes (-) separated by spaces.
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <button type="button" id="toMorseBtn" class="btn btn-primary">
                            <i class="fas fa-arrow-down me-2"></i>Text to Morse
                        </button>
                        <button type="button" id="fromMorseBtn" class="btn btn-warning ms-2">
                            <i class="fas fa-arrow-up me-2"></i>Morse to Text
                        </button>
                        <button type="button" id="clearBtn" class="btn btn-outline-secondary ms-3">
                            <i class="fas fa-trash-alt me-2"></i>Clear
                        </button>
                    </div>

                    <div id="resultSection" style="display: none;">
                        <div class="border-top pt-4">
                            <label for="resultOutput" class="form-label fw-semibold">
                                <i class="fas fa-check-circle me-2 text-success"></i>Result
                            </label>
                            <textarea class="form-control" id="resultOutput" rows="4" readonly
                                style="font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;"></textarea>
                            <div class="mt-2">
                                <button type="button" id="copyBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-copy me-2"></i>Copy Result
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Morse Code Reference --}}
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Morse Code Reference</h5>
                </div>
                <div class="card-body">
                    <div class="row small">
                        <div class="col-md-3">
                            <strong>Letters</strong><br>
                            A: .-<br>B: -...<br>C: -.-.<br>D: -..<br>E: .<br>F: ..-.<br>G: --.<br>H: ....<br>I: ..
                        </div>
                        <div class="col-md-3">
                            J: .---<br>K: -.-<br>L: .-..<br>M: --<br>N: -.<br>O: ---<br>P: .--.<br>Q: --.-<br>R: .-.
                        </div>
                        <div class="col-md-3">
                            S: ...<br>T: -<br>U: ..-<br>V: ...-<br>W: .--<br>X: -..-<br>Y: -.--<br>Z: --..
                        </div>
                        <div class="col-md-3">
                            <strong>Numbers</strong><br>
                            0: -----<br>1: .----<br>2: ..---<br>3: ...--<br>4: ....-<br>5: .....<br>6: -....<br>7: --...<br>8: ---..<br>9: ----.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textInput = document.getElementById('textInput');
    const resultOutput = document.getElementById('resultOutput');
    const resultSection = document.getElementById('resultSection');
    const toMorseBtn = document.getElementById('toMorseBtn');
    const fromMorseBtn = document.getElementById('fromMorseBtn');
    const clearBtn = document.getElementById('clearBtn');
    const copyBtn = document.getElementById('copyBtn');

    const morseCode = {
        'A': '.-', 'B': '-...', 'C': '-.-.', 'D': '-..', 'E': '.', 'F': '..-.', 'G': '--.', 'H': '....',
        'I': '..', 'J': '.---', 'K': '-.-', 'L': '.-..', 'M': '--', 'N': '-.', 'O': '---', 'P': '.--.',
        'Q': '--.-', 'R': '.-.', 'S': '...', 'T': '-', 'U': '..-', 'V': '...-', 'W': '.--', 'X': '-..-',
        'Y': '-.--', 'Z': '--..', '0': '-----', '1': '.----', '2': '..---', '3': '...--', '4': '....-',
        '5': '.....', '6': '-....', '7': '--...', '8': '---..', '9': '----.', ' ': '/'
    };

    const reverseMorseCode = Object.fromEntries(
        Object.entries(morseCode).map(([key, value]) => [value, key])
    );

    function textToMorse() {
        const text = textInput.value.toUpperCase();

        if (!text.trim()) {
            alert('Please enter some text to convert.');
            return;
        }

        const result = text.split('').map(char => {
            return morseCode[char] || char;
        }).join(' ');

        resultOutput.value = result;
        resultSection.style.display = 'block';
    }

    function morseToText() {
        const morse = textInput.value.trim();

        if (!morse) {
            alert('Please enter Morse code to convert.');
            return;
        }

        try {
            const result = morse.split(' ').map(code => {
                if (code === '') return '';
                return reverseMorseCode[code] || code;
            }).join('');

            resultOutput.value = result;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('Invalid Morse code format. Please check your input.');
        }
    }

    function clearAll() {
        textInput.value = '';
        resultOutput.value = '';
        resultSection.style.display = 'none';
    }

    function copyResult() {
        resultOutput.select();
        document.execCommand('copy');

        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        copyBtn.classList.replace('btn-outline-primary', 'btn-success');

        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.classList.replace('btn-success', 'btn-outline-primary');
        }, 2000);
    }

    toMorseBtn.addEventListener('click', textToMorse);
    fromMorseBtn.addEventListener('click', morseToText);
    clearBtn.addEventListener('click', clearAll);
    copyBtn.addEventListener('click', copyResult);
});
</script>
