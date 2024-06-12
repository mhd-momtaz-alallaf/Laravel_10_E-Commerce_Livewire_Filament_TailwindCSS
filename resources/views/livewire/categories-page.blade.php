<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6">
            {{-- Listing the categories items dynamically from the database, the $categories collection has been passed from the CategoriesPage Component Class --}}
            @foreach ($categories as $category)
                {{-- The Category Products page Link --}}
                <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    href="/products?selected_categories[0]={{ $category->id }}" wire:key="{{$category->id}}">
                    <div class="p-4 md:p-5">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                {{-- Category Image Path --}} {{-- . ltrim($category->image, '/') will remove any any leading slashes (/image_path) from the $category->image path, ensuring there are no double slashes in the resulting URL --}}
                                <img class="h-[5rem] w-[5rem]" src="{{url('storage/' . ltrim($category->image, '/') )}}" alt="{{$category->name}}">
                                
                                {{-- Category Name --}}
                                <div class="ms-3">
                                    <h3 class="group-hover:text-blue-600 text-2xl font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200">
                                        {{$category->name}}
                                    </h3>
                                </div>
                            </div>

                            <div class="ps-3">
                                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>