<x-app>
    <x-slot name="header">
        <div class="flex">
            ...naughty, you just had to click it. OK. Bonus.
        </div>
    </x-slot>
    <div class="p-4 bg-white rounded-lg shadow-xs w-full">
        <table>
            <thead>
                <tr class="bg-gray-600 text-white text-left">
                    <th class="w-36">Date</th>
                    <th class="text-right" style="width: 80px;">Currency</th>
                    <th class="text-right" style="width: 80px;">Rate</th>
                    <th class="text-right" style="width: 100px;">Purchased</th>
                    <th class="text-right" style="width: 90px;">Surcharge</th>
                    <th class="text-right" style="width: 80px;">Discount</th>
                    <th class="text-right" style="width: 100px;">Paid</th>
                    <th class="text-right" style="width: 80px;">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($data as $order)
                    <tr>
                        <td>{{$order->updated_at}}</td>
                        <td>{{$order->currency}}</td>
                        <td class="text-right">{{$order->rate}}</td>
                        <td class="text-right">{{$order->purchased}}</td>
                        <td class="text-right">{{number_format($order->surcharge,2)}}</td>
                        <td class="text-right">{{($order->discount == 0)? '' : number_format($order->discount,2) . ' $'}}</td>
                        <td class="text-right">{{number_format($order->paid,2)}} $</td>
                        <td class="text-right">{{$order->action}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
    <div class="mt-2 text-xs" >
        {{ $data->appends(request()->query())->links() }}
    </div>

    <div class="w-full mt-2">
        <center>
            <a href="{{route('home')}}">
                <x-primary-button>Back</x-primary-button>
            </a>
        </center>
    </div>
</x-app>
