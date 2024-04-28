
<div class="col-md-8">
    <div class="card">
        <div class="card-header">{{ __('gym.user.balance') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.balance.update', ['id' => $user->id]) }}">
                @csrf
                @method('PATCH')
                <div class="row mb-3">
                    <label
                        for="current_balance"
                        class="col-md-4 col-form-label text-md-end"
                    >{{ __('gym.current_balance')}}</label>
                    <div class="col-md-6">
                        <input
                            id="current_balance"
                            class="form-control"
                            name="balance"
                            value="{{ $user->clientInfo?->balance . ' ' .  __('gym.currency_symbol') }}"
                            disabled
                        >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="balance"
                           class="col-md-4 col-form-label text-md-end">{{ __('gym.apply_balance_amount')}}</label>
                    <div class="col-md-6">
                        <input
                            id="balance"
                            type="number"
                            class="form-control"
                            name="balance"
                            value=""
                            required
                        >
                    </div>
                </div>
                <div class="col-md-8 offset-md-4">
                    <button class="btn btn-success" type="submit"> {{ __('gym.balance_change') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>
