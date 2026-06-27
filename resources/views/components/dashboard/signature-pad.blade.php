{{-- Signature Pad Component --}}
<div x-data="{
    drawing: false,
    canvas: null,
    ctx: null,
    lastX: 0,
    lastY: 0,
    isEmpty: true,

    init() {
        this.canvas = this.$refs.canvas;
        this.ctx = this.canvas.getContext('2d');
        this.resizeCanvas();
        window.addEventListener('resize', () => this.resizeCanvas());
    },

    resizeCanvas() {
        const rect = this.canvas.parentElement.getBoundingClientRect();
        this.canvas.width = rect.width;
        this.canvas.height = 200;
        this.ctx.strokeStyle = '#1a202c';
        this.ctx.lineWidth = 2.5;
        this.ctx.lineCap = 'round';
        this.ctx.lineJoin = 'round';
    },

    startDraw(e) {
        this.drawing = true;
        const pos = this.getPos(e);
        this.lastX = pos.x;
        this.lastY = pos.y;
    },

    draw(e) {
        if (!this.drawing) return;
        e.preventDefault();
        const pos = this.getPos(e);
        this.ctx.beginPath();
        this.ctx.moveTo(this.lastX, this.lastY);
        this.ctx.lineTo(pos.x, pos.y);
        this.ctx.stroke();
        this.lastX = pos.x;
        this.lastY = pos.y;
        this.isEmpty = false;
    },

    stopDraw() {
        this.drawing = false;
    },

    clearPad() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.isEmpty = true;
    },

    getPos(e) {
        const rect = this.canvas.getBoundingClientRect();
        if (e.touches) {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        }
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    },

    getDataURL() {
        return this.canvas.toDataURL('image/png');
    }
}"
class="w-full"
>
    <div class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 overflow-hidden cursor-crosshair hover:border-[#2C3DA6]/40 transition-colors duration-200">
        <canvas
            x-ref="canvas"
            @mousedown="startDraw($event)"
            @mousemove="draw($event)"
            @mouseup="stopDraw()"
            @mouseleave="stopDraw()"
            @touchstart.prevent="startDraw($event)"
            @touchmove.prevent="draw($event)"
            @touchend="stopDraw()"
            class="w-full"
            style="touch-action: none;"
        ></canvas>
    </div>

    <div class="flex items-center justify-between mt-3">
        <p class="text-xs text-gray-400" x-text="isEmpty ? 'Tanda tangani di area di atas' : 'Tanda tangan terisi'"></p>
        <div class="flex items-center gap-2">
            <button type="button" @click="clearPad()"
                    class="px-3 py-1.5 text-xs font-medium text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                Hapus
            </button>
            <button type="button"
                    x-show="!isEmpty"
                    class="px-3 py-1.5 text-xs font-medium text-white bg-[#2C3DA6] rounded-lg hover:bg-[#2C3DA6]/90 transition-colors duration-200">
                Simpan
            </button>
        </div>
    </div>
</div>
