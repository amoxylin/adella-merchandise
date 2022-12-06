<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineProps({
    trashed_manufacturers: Object,
});
</script>

<template>
    <AppLayout title="Product Manufacturers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trashed Manufacturers
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
                                                    ID
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Manufacturer Name
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-black px-6 py-4 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-zinc-50 border-b transition duration-300 ease-in-out hover:bg-zinc-100"
                                                v-if="
                                                    trashed_manufacturers.length >
                                                    0
                                                " v-for="trashed_manufacturer in trashed_manufacturers"
                                                :key="trashed_manufacturer.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ trashed_manufacturer.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{
                                                            trashed_manufacturer.name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'products.manufacturers.restore',
                                                            trashed_manufacturer.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Restore
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="
    route(
        'products.manufacturers.destroy_permanent',
        trashed_manufacturer.id
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
                                                <td colspan="4"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    No trashed data
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
