<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
    
        if ($request->filled('keyword')) {
            $query->where(
                'name',
                'like',
                '%' . $request->keyword . '%'
            );
        }
    
        $customers = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $totalCustomers = $query->count();
        $totalCompanies = $customers
            ->whereNotNull('company')
            ->where('company', '!=', '')
            ->pluck('company')
            ->unique()
            ->count();
    
        return view('customers.index', [
            'customers' => $customers,
            'totalCustomers' => $totalCustomers,
            'totalCompanies' => $totalCompanies,
        ]);
    }


    public function create()
    {
        return view('customers.create');
    }


    // レコード取得保存・バリデーション
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => ['nullable', 'regex:/^[0-9\-]+$/'],
            'company' => 'nullable|max:255',
            'memo' => 'nullable|max:1000',
        ],
        [
            'name.required' => '名前は必須です',
            'name.max' => '名前は255文字以内で入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.max' => 'メールアドレスは255文字以内で入力してください',
            'phone.regex' => '電話番号は数字とハイフンのみ入力できます',
            'company.max' => '会社名は255文字以内で入力してください',
            'memo.max' => '備考は1000文字以内で入力してください',
        ]);

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', '顧客を登録しました');
    }


    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer
        ]);
    }


    // 更新・バリデーション
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => ['nullable', 'regex:/^[0-9\-]+$/'],
            'company' => 'nullable|max:255',
            'memo' => 'nullable|max:1000',
        ],
        [
            'name.required' => '名前は必須です',
            'name.max' => '名前は255文字以内で入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.max' => 'メールアドレスは255文字以内で入力してください',
            'phone.regex' => '電話番号は数字とハイフンのみ入力できます',
            'company.max' => '会社名は255文字以内で入力してください',
            'memo.max' => '備考は1000文字以内で入力してください',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', '顧客情報を更新しました');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.deleteComplete');
    }


    public function deleteComplete()
    {
        return view('customers.delete-complete');
    }
    

    public function statistics()
    {
        $totalCustomers = Customer::count();
    
        $totalCompanies = Customer::whereNotNull('company')
            ->where('company', '!=', '')
            ->distinct()
            ->count('company');
    
        $companyRanking = Customer::select('company')
            ->selectRaw('COUNT(*) as total')
            ->whereNotNull('company')
            ->where('company', '!=', '')
            ->groupBy('company')
            ->orderByDesc('total')
            ->get();

        $monthlyCustomers = Customer::selectRaw(
            'DATE_FORMAT(created_at, "%Y-%m") as month,
            COUNT(*) as total'
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        return view('customers.statistics', compact(
            'totalCustomers',
            'totalCompanies',
            'companyRanking',
            'monthlyCustomers'
        ));
    }
}