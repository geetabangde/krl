@extends('frontend.layouts.dashboard-app')
@section('title') {{ 'contact' }} @endsection
@section('content')
<main class="main">
   
        <section class="res">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Total No. of Order</h4>
                                <h3>{{$ordersCount}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Total LR</h4>
                                <h3>{{$totalLrCount}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Order Completed</h4>
                                <h3>{{$completedCount}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-custom mb-4">
                        <div class="portfolio-sidebar">
                            <div class="widget">
                                <h4 class="title">Order Processing</h4>
                                <h3>{{$processingCount}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <!-- Order Booking Table Section -->
            <div class="card shadow-sm p-4 mt-4">
                <div
                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
                    <div>
                        <h5><i class="fas fa-box-open me-2 text-warning"></i>Recent Order</h5>
                        <p class="text-muted mb-2 mb-sm-0">Track your most recent orders and manage their status easily.
                        </p>
                    </div>

                    <a href="#" class="btn btn-danger rounded mt-2 mt-sm-0" data-bs-toggle="modal"
                        data-bs-target="#addOrderModal">
                        <i class="fas fa-plus"></i> Add Order Booking
                    </a>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Order ID</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($orders); --}}
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ $order->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                                        @php
                                        // Fetch Freight Bills (order_id is JSON)
                                        $freightBill = DB::table('freight_bill')
                                            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order->order_id])
                                            ->get();
                                        
                                        // Check if any Invoice exists for the Freight Bills
                                        $hasInvoice = false;
                                        if (!empty($freightBill)) {
                                            foreach ($freightBill as $billCheck) {
                                                $invoiceCheck = \App\Models\Invoice::where('freight_bill_id', $billCheck->id)->first();
                                                if ($invoiceCheck) {
                                                    $hasInvoice = true;
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        $statusString = strtolower($order->status);
                                        // dd($statusString);
                                        $badgeClass = 'bg-secondary';
                                        
                                        if ($statusString === 'request-invioce') {
                                            $badgeClass = $hasInvoice ? 'bg-success' : 'bg-danger';
                                        
                                        } elseif ($statusString === 'request-freeghtbill') {
                                            $badgeClass = (!empty($freightBill) && count($freightBill) > 0) ? 'bg-success' : 'bg-danger';
                                        
                                        } elseif ($statusString === 'request-lr') {
                                            $badgeClass = $order->lr ? 'bg-success' : 'bg-danger';
                                        
                                        } elseif ($statusString === 'pending') {
                                            $badgeClass = 'bg-warning text-dark';
                                        
                                        } elseif (in_array($statusString, ['processing', 'confirmed'])) {
                                            $badgeClass = 'bg-info';
                                        
                                        } elseif ($statusString === 'completed') {
                                            $badgeClass = 'bg-primary';
                                        
                                        } elseif ($statusString === 'cancelled') {
                                            $badgeClass = 'bg-danger';
                                        }
                                        
                                        $statusFormatted = ucwords(str_replace(['-', '_'], ' ', $order->status));
                                        @endphp
                                        
                                        <td class="status-cell">
                                            <span class="badge {{ $badgeClass }}">{{ $statusFormatted }}</span>
                                        </td>


                                    <td>
                                        <a href="{{ route('user.order-details', $order->order_id) }}">
                                            <button class="btn btn-sm btn-light text-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </section>

        <!-- Add Order Modal -->
        <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderModalLabel"><i class="fas fa-plus-circle me-2"></i>New Order
                            Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @php
                        use App\Models\Destination;
                        $destinations = Destination::all();
                    @endphp

                    <form action="{{ route('order.save') }}" method="POST">
                            {{-- Hidden user_id --}}
                            <input type="hidden" name="customer_id" value="{{ auth()->id() }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" required placeholder="Order description">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">From Destination</label>
                                    <select name="from_destination_id" class="form-control" required>
                                        <option value="">-- Select From --</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">To Destination</label>
                                    <select name="to_destination_id" class="form-control" required>
                                        <option value="">-- Select To --</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->destination }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Date</label>
                                    <input type="date" name="order_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Order</button>
                            </div>
                    </form>

                </div>
            </div>
        </div>


    </main>

@endsection