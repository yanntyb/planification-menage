<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}'),
        days: 0,
        hours: 0,
        minutes: 0,
        init() {
            this.$watch('days', () => this.push());
            this.$watch('hours', () => this.push());
            this.$watch('minutes', () => this.push());
            this.pull();
        },
        pull() {
            this.days = this.state.days ?? 0;
            this.hours = this.state.hours ?? 0;
            this.minutes = this.state.minutes ?? 0;
        },
        push() {
            this.state = {
                days: this.days,
                hours: this.hours,
                minutes: this.minutes,
            };
        }
    }" class="grid grid-cols-3 gap-1">
        <x-filament::input.wrapper>
            <x-filament::input type="number" x-model="days"/>
            <x-slot name="suffix">Jours</x-slot>
        </x-filament::input.wrapper>
        <x-filament::input.wrapper>
            <x-filament::input type="number" x-model="hours"/>
            <x-slot name="suffix">Heures</x-slot>
        </x-filament::input.wrapper>
        <x-filament::input.wrapper>
            <x-filament::input type="number" x-model="minutes"/>
            <x-slot name="suffix">Minute</x-slot>
        </x-filament::input.wrapper>
    </div>
</x-dynamic-component>
