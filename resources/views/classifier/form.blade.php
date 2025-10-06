@extends('layouts.app')

@section('title', 'MCC Classifier')

@section('content')
    <div class="container py-4">
        <h1 class="mb-3">MCC classifier demo</h1>
        <p class="text-muted">Send a short description and the classifier service will suggest the most likely MCC category.</p>

        <form method="POST" action="{{ route('classifier.classify') }}" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="text" class="form-label">Product description</label>
                <textarea id="text" name="text" class="form-control" rows="4" maxlength="500" required>{{ old('text', $inputText ?? '') }}</textarea>
                @error('text')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="top_k" class="form-label">Top K</label>
                    <input id="top_k" name="top_k" type="number" min="1" max="10" class="form-control" value="{{ old('top_k', $topK ?? 3) }}">
                </div>
                <div class="col-md-3">
                    <label for="top_goods" class="form-label">Examples per class</label>
                    <input id="top_goods" name="top_goods" type="number" min="0" max="20" class="form-control" value="{{ old('top_goods', $topGoods ?? 5) }}">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Classify</button>
            </div>
        </form>

        @isset($serviceMessage)
            <div class="alert {{ ($serviceError ?? false) ? 'alert-danger' : 'alert-info' }}" role="alert">
                {{ $serviceMessage }}
            </div>
        @endisset

        @if (!empty($predictions))
            <div class="card">
                <div class="card-header">Predictions</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">MCC</th>
                                    <th scope="col">Probability</th>
                                    <th scope="col">Examples</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($predictions as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item['category'] ?? $item['label'] ?? 'n/a' }}</td>
                                        <td>{{ $item['mcc'] ?? 'n/a' }}</td>
                                        <td>{{ isset($item['probability']) ? number_format($item['probability'], 3) : 'n/a' }}</td>
                                        <td>
                                            @if (!empty($item['examples']))
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($item['examples'] as $example)
                                                        <li>{{ $example }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No examples</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
