@props([
    'footerButton' => null,
    'iconColor' => 'red',
    'title' => null,
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
                    class="relative w-auto w-11/12 md:w-2/5 mx-auto transition-all duration-200 ease-out mt-8"
                >
                    <div class="relative flex flex-col justify-between bg-white border rounded">
                        <!-- Dialogue body -->
                        <div class="w-full flex items-start space-x-4 p-4">
                            <div class="w-16">
                                <div class="flex items-center justify-center w-12 h-12 text-{{ $iconColor }}-600 bg-{{ $iconColor }}-200 rounded-full">
                                    <x-icon type="info" width="6"/>
                                </div>
                            </div>
                            <div>
                                @if($title)
                                    <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
                                @endif

                                {{ $slot }}
                            </div>
                        </div>

                        <!-- Dialogue footer -->
                        <div class="bg-gray-100 p-4">
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
                    setTimeout(() => {this.state = 'CLOSED'}, 100)
                    document.body.classList.remove('overflow-y-hidden');
                },
                isOpen() { return this.state === 'OPEN' },
                isOpening() { return this.state !== 'CLOSED' },
            }
        }
    </script>
</div>
