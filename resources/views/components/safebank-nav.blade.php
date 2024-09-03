@props(['authguard'])
<div class="flex justify-between">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
        {{ $slot }}
    </h2>
    <div>
        <p class="text-sm">{{"Agência: " . $authguard->account()->first()->agency}}</p>
        <p class="text-sm">{{"Conta: " . $authguard->account()->first()->number}}</p>
    </div>
</div>