@extends('layouts.admin')

@section('title', 'Edit Invoice')
@section('page-title', 'Edit Invoice')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px;">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.invoices') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.35)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.transform='scale(1)';">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">Edit Invoice</h1>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Update the invoice details</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <form method="POST" action="{{ route('admin.invoices.update', $invoice) }}">
            @csrf
            @method('PUT')
            
            <!-- Invoice Information Card -->
            <div class="futuristic-card p-4 p-md-5 mb-4" style="border-color: rgba(0, 102, 255, 0.2);">
                <div class="row">
                    <div class="col-12 col-md-3 mb-4 mb-md-0">
                        <h3 class="h5 fw-bold mb-2" style="color: var(--text-primary);">Invoice Information</h3>
                        <p class="small mb-0" style="color: var(--text-secondary);">Update the invoice details.</p>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tenant_id" class="form-label fw-semibold" style="color: var(--text-primary);">Tenant</label>
                                <select name="tenant_id" id="tenant_id" required class="form-select @error('tenant_id') is-invalid @enderror">
                                    <option value="">Select a tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->tenant_id }}" {{ old('tenant_id', $invoice->tenant_id) == $tenant->tenant_id ? 'selected' : '' }}>
                                            {{ $tenant->name }} ({{ $tenant->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="payment_id" class="form-label fw-semibold" style="color: var(--text-primary);">Related Payment (Optional)</label>
                                <select name="payment_id" id="payment_id" class="form-select @error('payment_id') is-invalid @enderror">
                                    <option value="">Select a payment (optional)</option>
                                    @foreach($payments as $payment)
                                        <option value="{{ $payment->payment_id }}" {{ old('payment_id', $invoice->payment_id) == $payment->payment_id ? 'selected' : '' }}>
                                            ₱{{ number_format($payment->amount, 2) }} - {{ $payment->tenant->name ?? 'N/A' }} ({{ $payment->payment_date ? $payment->payment_date->format('M j, Y') : 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="date" class="form-label fw-semibold" style="color: var(--text-primary);">Invoice Date</label>
                                <input type="date" name="date" id="date" required
                                       class="form-control @error('date') is-invalid @enderror"
                                       value="{{ old('date', $invoice->date ? $invoice->date->format('Y-m-d') : '') }}">
                                @error('date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="due_date" class="form-label fw-semibold" style="color: var(--text-primary);">Due Date</label>
                                <input type="date" name="due_date" id="due_date" required
                                       class="form-control @error('due_date') is-invalid @enderror"
                                       value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}">
                                @error('due_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="amount" class="form-label fw-semibold" style="color: var(--text-primary);">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                                           class="form-control @error('amount') is-invalid @enderror"
                                           value="{{ old('amount', $invoice->amount) }}" placeholder="0.00">
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label fw-semibold" style="color: var(--text-primary);">Status</label>
                                <select name="status" id="status" required class="form-select @error('status') is-invalid @enderror">
                                    <option value="">Select status</option>
                                    <option value="draft" {{ old('status', $invoice->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="sent" {{ old('status', $invoice->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    <option value="cancelled" {{ old('status', $invoice->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold" style="color: var(--text-primary);">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Optional invoice notes">{{ old('notes', $invoice->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.invoices') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-neon">
                    <i class="fas fa-save me-2"></i>Update Invoice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
