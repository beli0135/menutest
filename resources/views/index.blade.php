<x-app>
    <x-slot name="header">
        <div class="flex">
            <img class="mr-2" src="{{asset('storage/menulogo.jpg')}}" alt="menulogo" width="32" height="32"/>
            MENU candidate test - currency purchase
        </div>
    </x-slot>

    @if(isset($message))
        <p class="mb-2 ml-2 text-sm">{{$message}}</p>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if(isset($currencies))
        <div class="p-4 bg-white rounded-lg shadow-xs">
            <form action="{{route('calculate')}}" method="POST" >
                @csrf
                @method('POST')

                <div class="text-sm flex space-x-6">
                    <div class="pb-2 w-36">
                        <label for="currency_dd">Purchase</label>
                        <select name="currency_dd" id="currency_dd" required
                                class="mb-1 w-full border border-gray-200 rounded-md text-sm dark:border-gray-600">
                            <option value="">Select currency</option>
                            @foreach ($currencies as $data)
                                <option value="{{ $data->currency }}">{{$data->currency .' - ' . $data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-36">
                        <label for="amount">Amount</label>
                        <input class="pl-2 border border-gray-200 rounded-md"
                               type="number" name="amount" id="amount" min="50" value="50"/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-primary-button class="ml-4">Calculate</x-primary-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 flex space-x-6">
            <a href="{{route('ordergrid')}}">
                <x-red-button class="ml-4">DO NOT CLICK</x-red-button>
            </a>
            <x-primary-button id="btnrates">View rates (AJAX)</x-primary-button>
        </div>

        <div class="w-full mb-2 mt-4 text-sm" id="ratesdiv">

        </div>
    @endif

    @if (isset($calcData))
        <div class="mt-4 p-4 bg-white rounded-lg shadow-xs text-sm flex items-center">
            <p>Transaction cost: <p class="ml-2 mr-2 font-semibold">{{number_format($calcData['total_USD'],2)}}</p> USD</p>
            <form action="{{route('createOrder',$calcData)}}" method="POST" onsubmit="return ConfirmPurchase()">
                @method('PUT')
                @csrf
                <a href="{{route('home')}}">
                    <x-secondary-button class="ml-4">Cancel</x-secondary-button>
                </a>
                <x-primary-button>Purchase</x-primary-button>
            </form>
        </div>
    @endif


</x-app>

<script>
    function ConfirmPurchase()
    {
        var x = confirm("Are you sure you want to pruchase?");
        if (x)
            return true;
        else
            return false;
    }

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btnrates').on('click', function () {

            $("#ratesdiv").html('');
            $.ajax({
                url: "{{url('api/exchange-rates')}}",
                type: "GET",
                data: {
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#ratesdiv').html('');
                    $.each(result, function (key, value) {
                        $("#ratesdiv").append(
                            '<p>'+key+': '+ value +'</p>'
                        );
                    });
                }
            });
        });
    });
</script>