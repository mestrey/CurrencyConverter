<template>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="text-center py-4">
                <h1>Currency Converter</h1>
            </div>
            <router-view />
        </div>
    </div>
</template>

<script>

export default {
    name: 'App'
}

</script>

<style>
.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, .3);
    border-radius: 50%;
    border-top-color: black;
    animation: spin 1s ease-in-out infinite;
    -webkit-animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        -webkit-transform: rotate(360deg);
    }
}

@-webkit-keyframes spin {
    to {
        -webkit-transform: rotate(360deg);
    }
}
</style>