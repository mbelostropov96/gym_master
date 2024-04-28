<div class="card">
    <div class="card-header">{{ __('gym.user.balance_history') }}</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">{{ __('gym.operation_id') }}</th>
                    <th scope="col">{{ __('gym.operation_created_at') }} </th>
                    <th scope="col">{{ __('gym.old_balance') }}</th>
                    <th scope="col">{{ __('gym.balance_change_amount') }} </th>
                    <th scope="col">{{ __('gym.operation_description') }} </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->balanceEvents as $balanceEvent)
                    <tr>
                        <th>{{ $balanceEvent->id }}</th>
                        <td>{{ $balanceEvent->created_at }}</td>
                        <td>{{ $balanceEvent->old_balance }}</td>
                        <td>{{ $balanceEvent->balance_change }}</td>
                        <td>{{ $balanceEvent->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
