<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StockMutationService;
use App\Models\StockMutation;
use App\Models\Product;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\Auth;

class StockMutationController extends Controller
{
    protected $mutationService;

    public function __construct(StockMutationService $mutationService)
    {
        $this->mutationService = $mutationService;
    }

    public function index()
    {
        $mutations = StockMutation::with(['product', 'user', 'supplier'])
            ->latest()
            ->paginate(15);

        return view('mutations.index', compact('mutations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type'        => 'required|in:in,out',
            'quantity'    => 'required|integer|min:1',
            'notes'       => 'nullable|string|max:255',
        ]);

        try {
            $mutation = $this->mutationService->executeMutation($validated, Auth::id());
            return redirect()->back()->with('success', "Mutasi {$mutation->reference_number} berhasil diproses!");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
