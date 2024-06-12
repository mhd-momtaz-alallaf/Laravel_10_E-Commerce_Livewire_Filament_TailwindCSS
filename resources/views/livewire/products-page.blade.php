<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24 -mx-3">
                <div class="w-full pr-2 lg:w-1/4 lg:block">
                    {{-- Categories Filtering section --}}
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400"> Categories</h2>

                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>

                        {{-- categories List --}}
                        <ul>
                            @foreach ($categories as $category)
                                <li class="mb-4" wire:key="{{$category->id}}">
                                    <label for="{{$category->slug}}" class="flex items-center dark:text-gray-400 ">
                                        {{-- Category Checkbox --}} {{-- wire:model.live="selected_categories" will listen to the chekbox and it will send the selected categories to the ProductPage Component --}}
                                        <input type="checkbox" wire:model.live="selected_categories" id="{{$category->slug}}" value="{{$category->id}}" class="w-4 h-4 mr-2">
                                        
                                        {{-- Category Name --}}
                                        <span class="text-lg dark:text-gray-400">{{$category->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Brands Filtering section --}}
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Brand</h2>

                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        {{-- Brands List --}}
                        <ul>
                            @foreach ($brands as $brand)
                                <li class="mb-4" wire:key="{{$brand->id}}">
                                    <label for="" class="flex items-center dark:text-gray-300">
                                        {{-- Brand Checkbox --}} {{-- wire:model.live="selected_brands" will listen to the chekbox and it will send the selected brands to the ProductPage Component --}}
                                        <input type="checkbox" wire:model.live="selected_brands" id="{{$brand->slug}}" value="{{$brand->id}}" class="w-4 h-4 mr-2">
                                        
                                        {{-- Brand Name --}}
                                        <span class="text-lg dark:text-gray-400">{{$brand->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Product Status section --}}
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Product Status</h2>

                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        {{-- Product Status list--}}
                        <ul>
                            {{-- Featured Products Status --}}
                            <li class="mb-4">
                                <label for="featured" class="flex items-center dark:text-gray-300">
                                    {{-- Featured Products Checkbox --}} {{-- wire:model.live="featured" will listen to the chekbox and it will send the value to the ProductPage Component --}}
                                    <input type="checkbox" wire:model.live="featured" id="featured" value="1" class="w-4 h-4 mr-2">
                                    
                                    {{-- Status Name --}}
                                    <span class="text-lg dark:text-gray-400">Featured Products</span>
                                </label>
                            </li>

                            {{-- On Sale Status --}}
                            <li class="mb-4">
                                <label for="on_sale" class="flex items-center dark:text-gray-300">
                                    {{-- On Slae Checkbox --}} {{-- wire:model.live="on_sale" will listen to the chekbox and it will send the value to the ProductPage Component --}}
                                    <input type="checkbox" wire:model.live="on_sale" id="on_sale" value="1" class="w-4 h-4 mr-2">
                                    
                                    {{-- Status Name --}}
                                    <span class="text-lg dark:text-gray-400">On Sale</span>
                                </label>
                            </li>
                        </ul>
                    </div>
        
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Price</h2>

                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>

                        <div>
                            <input type="range" class="w-full h-1 mb-4 bg-blue-100 rounded appearance-none cursor-pointer" max="500000" value="100000" step="100000">

                            <div class="flex justify-between ">
                                <span class="inline-block text-lg font-bold text-blue-400 ">&#8377; 1000</span>
                                <span class="inline-block text-lg font-bold text-blue-400 ">&#8377; 500000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full px-3 lg:w-3/4">
                    <div class="px-3 mb-4">
                        <div class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex dark:bg-gray-900 ">
                            <div class="flex items-center justify-between">
                                <select name="" id="" class="block w-40 text-base bg-gray-100 cursor-pointer dark:text-gray-400 dark:bg-gray-900">
                                    <option value="">Sort by latest</option>
                                    <option value="">Sort by Price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Products List --}}
                    @foreach ($products as $product)
                        <div class="flex flex-wrap items-center" wire:key="{{$product->id}}">
                            <div class="w-full px-3 mb-6 sm:w-1/2 md:w-1/3">
                                <div class="border border-gray-300 dark:border-gray-700">
                                    <div class="relative bg-gray-200">
                                        {{-- Navigating to the product details page --}}
                                        <a href={{route('product-details', $product)}} class="">
                                            {{-- Showing only the first image of the product from the $product->images array --}} {{-- . ltrim($product->images[0], '/') will remove any any leading slashes (/image_path) from the $images path, ensuring there are no double slashes in the resulting URL --}}
                                            <img src="{{ url('storage/'. ltrim($product->images[0], '/')) }}" alt="{{$product->name}}" class="object-cover w-full h-56 mx-auto ">
                                        </a>
                                    </div>
                                    
                                    <div class="p-3 ">
                                        {{-- Displaying the product Name --}}
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <h3 class="text-xl font-medium dark:text-gray-400">
                                                {{$product->name}}
                                            </h3>
                                        </div>

                                        {{-- Displaying the product Price in 'USD' currency format --}}
                                        <p class="text-lg ">
                                            <span class="text-green-600 dark:text-green-600">
                                                {{Number::currency($product->price, 'USD')}}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                                        <a href="#" class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 bi bi-cart3 " viewBox="0 0 16 16">
                                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                            </svg>
                                            <span>Add to Cart</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- pagination start -->
                    <div class="flex justify-end mt-6">
                        {{$products->links()}}
                    </div>
                    <!-- pagination end -->
                </div>
            </div>
        </div>
    </section>
</div>