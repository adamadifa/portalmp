<x-app-layout>
    <!-- Top Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Products -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
                <h3 class="text-2xl font-bold text-gray-900">1,525</h3>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-indigo-50 border border-indigo-100">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Sales</p>
                <h3 class="text-2xl font-bold text-gray-900">10,892</h3>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-blue-50 border border-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Total Income -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Income</p>
                <h3 class="text-2xl font-bold text-gray-900">$157,342</h3>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-green-50 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Expenses</p>
                <h3 class="text-2xl font-bold text-gray-900">$12,453</h3>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-red-50 text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Sales Revenue (Mockup) -->
        <div class="lg:col-span-2 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <h3 class="text-base font-bold text-gray-900">Sales Revenue</h3>
                </div>
                <div class="flex items-center space-x-1 text-xs font-medium text-gray-500">
                    <button class="px-3 py-1.5 rounded-md hover:bg-gray-50">Monthly</button>
                    <button class="px-3 py-1.5 rounded-md hover:bg-gray-50">Quarterly</button>
                    <button class="px-3 py-1.5 rounded-md hover:bg-gray-50">Yearly</button>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 mb-6 text-xs text-gray-500">
                <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-indigo-200 mr-2"></span> One-Time Revenue</div>
                <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span> Recurring Revenue</div>
            </div>

            <!-- Bar Chart Visual Mockup -->
            <div class="relative h-64 w-full flex items-end justify-between px-2">
                <!-- Y-Axis labels -->
                <div class="absolute left-0 top-0 bottom-6 flex flex-col justify-between text-[10px] text-gray-400">
                    <span>150K</span>
                    <span>100K</span>
                    <span>50K</span>
                    <span>10K</span>
                    <span>0</span>
                </div>
                
                <!-- Grid lines -->
                <div class="absolute left-8 right-0 top-2 bottom-6 flex flex-col justify-between pointer-events-none">
                    <div class="w-full border-t border-gray-100"></div>
                    <div class="w-full border-t border-gray-100"></div>
                    <div class="w-full border-t border-gray-100"></div>
                    <div class="w-full border-t border-gray-100"></div>
                    <div class="w-full border-t border-gray-100"></div>
                </div>

                <!-- Bars -->
                <div class="ml-10 flex w-full justify-between items-end h-[calc(100%-1.5rem)] pb-1 z-10 relative">
                    <!-- Jan -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-32 absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-24 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">Jan</span>
                    </div>
                    <!-- Feb -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-40 absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-12 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">Feb</span>
                    </div>
                    <!-- Mar -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-48 absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-20 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">Mar</span>
                    </div>
                    <!-- Apr (Hovered/Active State) -->
                    <div class="flex flex-col items-center w-8 group relative z-20">
                        <!-- Tooltip mockup -->
                        <div class="absolute -top-16 -right-16 bg-white p-3 rounded-xl shadow-lg border border-gray-100 w-36 z-30 hidden group-hover:block">
                            <div class="text-[10px] text-gray-500 flex items-center mb-1"><span class="w-1.5 h-1.5 rounded-full bg-indigo-200 mr-1.5"></span>One-Time Revenue</div>
                            <div class="text-xs font-bold text-gray-900 mb-2 pl-3">$6,000</div>
                            <div class="text-[10px] text-gray-500 flex items-center mb-1"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5"></span>Recurring Revenue</div>
                            <div class="text-xs font-bold text-gray-900 pl-3">$25,000</div>
                        </div>
                        <div class="w-10 -ml-1 border-2 border-indigo-400 bg-indigo-50 rounded-t-md h-[140px] absolute bottom-0"></div>
                        <div class="w-full bg-indigo-500 rounded-t-md h-28 absolute bottom-0"></div>
                        <span class="text-xs font-medium text-gray-900 mt-2 absolute -bottom-6">Apr</span>
                    </div>
                    <!-- May -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-40 absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-3 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">May</span>
                    </div>
                    <!-- Jun -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-24 absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-8 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">Jun</span>
                    </div>
                    <!-- Jul -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-[150px] absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-36 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">Jul</span>
                    </div>
                    <!-- Aug -->
                    <div class="flex flex-col items-center w-8 group relative">
                        <div class="w-full bg-indigo-100 rounded-t-md h-32 absolute bottom-0 opacity-50"></div>
                        <div class="w-full bg-indigo-400 rounded-t-md h-16 absolute bottom-0"></div>
                        <span class="text-xs text-gray-400 mt-2 absolute -bottom-6">Aug</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories (Mockup) -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <h3 class="text-base font-bold text-gray-900">Top Categories</h3>
                </div>
                <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">See All</button>
            </div>

            <!-- Donut Chart -->
            <div class="relative flex justify-center items-center h-48 mb-6">
                <!-- SVG Donut Chart Mockup -->
                <svg class="w-40 h-40 transform -rotate-90" viewBox="0 0 100 100">
                    <!-- Electronics (Blue) ~ 68% -->
                    <circle cx="50" cy="50" r="40" stroke="#4f46e5" stroke-width="12" fill="none" stroke-dasharray="251.2" stroke-dashoffset="80" stroke-linecap="round" />
                    <!-- Fashion (Yellow) ~ 20% -->
                    <circle cx="50" cy="50" r="40" stroke="#f59e0b" stroke-width="12" fill="none" stroke-dasharray="251.2" stroke-dashoffset="200" stroke-linecap="round" class="transform origin-center rotate-[250deg]" />
                    <!-- Health (Green) ~ 8% -->
                    <circle cx="50" cy="50" r="40" stroke="#10b981" stroke-width="12" fill="none" stroke-dasharray="251.2" stroke-dashoffset="230" stroke-linecap="round" class="transform origin-center rotate-[320deg]" />
                    <!-- Home (Pink) ~ 4% -->
                    <circle cx="50" cy="50" r="40" stroke="#ec4899" stroke-width="12" fill="none" stroke-dasharray="251.2" stroke-dashoffset="240" stroke-linecap="round" class="transform origin-center rotate-[345deg]" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500">Total Sales</span>
                    <span class="text-lg font-bold text-gray-900">$125,000</span>
                </div>
            </div>

            <!-- Legend -->
            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-indigo-600 mr-2"></span>Electronics</div>
                    <div class="flex items-center"><span class="text-gray-500 mr-2">$85,000</span><span class="font-bold text-gray-900">68%</span></div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-yellow-400 mr-2"></span>Fashion</div>
                    <div class="flex items-center"><span class="text-gray-500 mr-2">$25,000</span><span class="font-bold text-gray-900">20%</span></div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-emerald-400 mr-2"></span>Health & Wellness</div>
                    <div class="flex items-center"><span class="text-gray-500 mr-2">$10,000</span><span class="font-bold text-gray-900">8%</span></div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-pink-400 mr-2"></span>Home & Living</div>
                    <div class="flex items-center"><span class="text-gray-500 mr-2">$5,000</span><span class="font-bold text-gray-900">4%</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-base font-bold text-gray-900">Recent Activity</h3>
                </div>
                <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">See All</button>
            </div>

            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Order #2048</p>
                            <p class="text-xs text-gray-500">John Doe &bull; 12 Jan 25</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg">New Order</span>
                </div>
                <!-- Item 2 -->
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Low Stock Alert</p>
                            <p class="text-xs text-gray-500">MacBook Air M2 &bull; 10 Jan 25</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-lg">Low Stock</span>
                </div>
                <!-- Item 3 -->
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Promo code "SUMMER20"</p>
                            <p class="text-xs text-gray-500">Applied 52 times &bull; 8 Jan 25</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium text-purple-600 bg-purple-50 rounded-lg">Campaign</span>
                </div>
                <!-- Item 4 -->
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">System Update</p>
                            <p class="text-xs text-gray-500">Version 1.2.1 &bull; 2 Jan 25</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg">System</span>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="lg:col-span-2 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <h3 class="text-base font-bold text-gray-900">Top Products</h3>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    <button class="flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                        Sort
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-gray-100">
                            <th class="pb-3 font-medium">Product</th>
                            <th class="pb-3 font-medium text-right">Stocks</th>
                            <th class="pb-3 font-medium text-right">Price</th>
                            <th class="pb-3 font-medium text-right">Sales</th>
                            <th class="pb-3 font-medium text-right">Earnings</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <!-- Product 1 -->
                        <tr class="hover:bg-gray-50/50">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">📱</div>
                                    <span class="font-medium text-gray-900">iPhone 15 Pro</span>
                                </div>
                            </td>
                            <td class="py-4 text-right text-gray-600">6,200</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$999.00</td>
                            <td class="py-4 text-right text-gray-600">4,800</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$4,795,200</td>
                        </tr>
                        <!-- Product 2 -->
                        <tr class="hover:bg-gray-50/50">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">💻</div>
                                    <span class="font-medium text-gray-900">MacBook Air M2</span>
                                </div>
                            </td>
                            <td class="py-4 text-right text-gray-600">1,020</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$1,299.00</td>
                            <td class="py-4 text-right text-gray-600">3,200</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$4,156,800</td>
                        </tr>
                        <!-- Product 3 -->
                        <tr class="hover:bg-gray-50/50">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">📱</div>
                                    <span class="font-medium text-gray-900">Google Pixel 8</span>
                                </div>
                            </td>
                            <td class="py-4 text-right text-gray-600">1,500</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$699.00</td>
                            <td class="py-4 text-right text-gray-600">800</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$559,200</td>
                        </tr>
                        <!-- Product 4 -->
                        <tr class="hover:bg-gray-50/50">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">👟</div>
                                    <span class="font-medium text-gray-900">Nike Air Max 90</span>
                                </div>
                            </td>
                            <td class="py-4 text-right text-gray-600">2,400</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$130.00</td>
                            <td class="py-4 text-right text-gray-600">1,800</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$234,000</td>
                        </tr>
                        <!-- Product 5 -->
                        <tr class="hover:bg-gray-50/50">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">🎧</div>
                                    <span class="font-medium text-gray-900">Galaxy Buds Pro</span>
                                </div>
                            </td>
                            <td class="py-4 text-right text-gray-600">850</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$199.00</td>
                            <td class="py-4 text-right text-gray-600">1,000</td>
                            <td class="py-4 text-right text-gray-900 font-medium">$199,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
