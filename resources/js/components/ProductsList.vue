<template>
    <div>
        <h1>Product List</h1>
        <div v-if="loading" class="loading">Loading...</div>
        <div v-else>
            <div v-for="product in products" :key="product.id" class="product">
                <h3>{{ product.title }}</h3>
                <p>{{ product.description }}</p>
                <p>Price: ${{ product.final_price }}</p>
            </div>

            <!-- Pagination Controls -->
            <div class="pagination">
                <!-- Previous Button -->
                <button
                    :disabled="currentPage === 1"
                    @click="changePage(currentPage - 1)">
                    Previous
                </button>

                <!-- Page Display -->
                <span>Page {{ currentPage }} of {{ totalPages }}</span>

                <!-- Next Button -->
                <button
                    :disabled="currentPage === totalPages"
                    @click="changePage(currentPage + 1)">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: [],       // Array to hold the products
            loading: true,      // Loading state
            currentPage: 1,     // The current page of the pagination
            totalPages: 1,      // Total number of pages from the API
        };
    },
    methods: {
        // Method to fetch products from the API based on the page number
        fetchProducts(page = 1) {
            fetch(`http://127.0.0.1:8000/api/products?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    this.products = data.data; // Get the products array from the API response
                    this.totalPages = data.last_page; // Get the total number of pages
                    this.currentPage = data.current_page; // Set the current page
                    this.loading = false; // Set loading to false once data is fetched
                })
                .catch(error => {
                    console.error("Error fetching products:", error);
                    this.loading = false; // Handle errors by setting loading to false
                });
        },
        // Method to change the page when clicking on the pagination controls
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.fetchProducts(page); // Fetch products for the selected page
            }
        }
    },
    mounted() {
        this.fetchProducts(); // Fetch the first page of products when the component is mounted
    }
};
</script>

<style scoped>
.product {
    border: 1px solid #ddd;
    margin: 10px;
    padding: 10px;
}
.loading {
    font-size: 1.5em;
    color: #333;
}
.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.pagination button {
    padding: 5px 10px;
    margin: 0 10px;
    cursor: pointer;
}
.pagination span {
    font-size: 1.2em;
}
</style>
