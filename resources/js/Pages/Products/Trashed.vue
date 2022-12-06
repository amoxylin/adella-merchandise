<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineProps({
    trashed_products: Object,
});
</script>

<template>
    <AppLayout title="Products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-50 overflow-hidden shadow-xl sm:rounded-lg mt-8">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Category
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Manufacturer
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Stock
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Price
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-zinc-50 border-b transition duration-300 ease-in-out hover:bg-zinc-100"
                                                v-if="trashed_products.length > 0"
                                                v-for="trashed_product in trashed_products" :key="trashed_product.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ trashed_product.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ trashed_product.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{
                                                            trashed_product.category_name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{
                                                            trashed_product.manufacturer_name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ trashed_product.stock }}
                                                    PCS
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    ${{ trashed_product.price }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'products.restore',
                                                            trashed_product.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Restore
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="
    route(
        'products.destroy_permanent',
        trashed_product.id
    )
                                                    ">
                                                    <DangerButton class="ml-4">
                                                        Permanently Remove
                                                    </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr class="bg-zinc-50 border-b transition duration-300 ease-in-out hover:bg-zinc-100"
                                                v-else>
                                                <td colspan="8"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    No trashed product
                                                    available
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
