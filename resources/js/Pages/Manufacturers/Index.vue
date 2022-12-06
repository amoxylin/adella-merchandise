<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

const search = ref(null);

defineProps({
    manufacturers: Object,
});

const onSearch = (search) => {
    location.href = `/products/manufacturers?search=${search}`;
};

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const searchQuery = params.get("search");
    search.value = searchQuery;
});
</script>

<template>
    <AppLayout title="Product Manufacturers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product Manufacturers
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex">
                    <div class="w-1/2">
                        <Link :href="route('products.manufacturers.create')">
                        <PrimaryButton>Add New Manufacturer</PrimaryButton>
                        </Link>
                        <Link :href="route('products.manufacturers.trashed')">
                        <PrimaryButton class="ml-4">
                            Trashed Manufacturer
                        </PrimaryButton>
                        </Link>
                    </div>
                    <div class="w-1/2">
                        <TextInput id="search" type="text" class="block w-full" placeholder="Search Manufacturers..."
                            v-model="search" @keyup.enter="onSearch(search)" />
                    </div>
                </div>
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
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-zinc-50 border-b" v-if="(manufacturers.length > 0)"
                                                v-for="manufacturer in manufacturers" :key="manufacturer.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ manufacturer.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ manufacturer.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'products.manufacturers.edit',
                                                            manufacturer.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Edit
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="
    route(
        'products.manufacturers.destroy',
        manufacturer.id
    )
                                                    ">
                                                    <DangerButton class="ml-4" type="submit">
                                                        Remove
                                                    </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr class="bg-gray-100 border-b transition duration-300 ease-in-out hover:bg-gray-200"
                                                v-else>
                                                <td colspan="4"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    There is no data available
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
