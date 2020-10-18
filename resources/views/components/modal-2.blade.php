@props([
    'header' => null,
    'width' => '3/5'
])
<div>
    <div x-data="modal()" x-on:keydown.escape="close()">
        <div @click="open()">
            {{ $trigger }}
        </div>
        <div x-show="isOpening()" x-cloak>
            <div
                :class="{ 'opacity-0': isOpening(), 'opacity-100': isOpen() }"
                class="fixed z-50 top-0 left-0 h-full w-full bg-black bg-opacity-50 transition duration-200 linear"
            >
                <div
                    :class="{ 'mt-4': isOpening(), 'mt-8': isOpen() }"
                    @click.away="close()"
                    class="relative w-auto w-11/12 md:w-{{ $width }} mx-auto transition-all duration-200 ease-out mt-8"
                >
                    <div class="relative flex flex-col justify-between bg-white border rounded">
                        <!-- Modal header -->
                        <div class="w-full flex items-center justify-between p-4 border-b border-gray-300">
                            <div class="w-4/5">
                                <span class="text-orange-600 font-bold text-lg">{{ $header }}</span>
                            </div>
                            <button @click="close()" class="transition duration-200 hover:text-red-600">
                                <x-icon type="close" />
                            </button>
                        </div>

                        <!-- Modal body -->
                        <div class="w-full p-4">
                            {{ $slot }}
                        </div>

                        <!-- Modal footer -->
                        <div class="border-t border-gray-300 p-4">
                            <div class="flex justify-end items-center">
                                <div class="flex items-center space-x-2">
                                    <x-button @click="close()" text="Nevermind" type="secondary" class="p-3 leading-none text-sm"/>
                                    {{ $footerButton }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function modal() {
            return {
                state: 'CLOSED', // [CLOSED, TRANSITION, OPEN]
                open() {
                    this.state = 'TRANSITION'
                    setTimeout(() => {
                        this.state = 'OPEN'
                        document.body.classList.add('overflow-y-hidden');
                    }, 50)
                },
                close() {
                    this.state = 'TRANSITION'
                    setTimeout(() => { this.state = 'CLOSED' }, 100)
                    document.body.classList.remove('overflow-y-hidden');
                },
                isOpen() { return this.state === 'OPEN' },
                isOpening() { return this.state !== 'CLOSED' },
            }
        }
    </script>
    @endpush
</div>
