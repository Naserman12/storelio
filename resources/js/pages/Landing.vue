<template>
  <div>

    <!-- Hero Section -->
    <section  class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-purple-600 text-white">

      <div class="text-center max-w-2xl">

        <h1 class="text-4xl md:text-6xl font-bold">
          Build Your Online Store in Minutes 🚀
        </h1>

        <p class="text-gray-600 mt-4 text-lg">
          Storelio is a SaaS platform that lets you create and manage your own e-commerce store without coding.
        </p>

        <div class="mt-6 flex justify-center gap-4">

          <router-link
            to="/register"
            class="bg-blue-500 text-white px-6 py-3 rounded-lg"
          >
            Get Started
          </router-link>

          <router-link
            to="/login"
            class="border px-6 py-3 rounded-lg"
          >
            Login
          </router-link>

        </div>

      </div>

    </section>

    <!-- Features -->
    <section class="py-20 px-6 bg-white">

      <h2 class="text-3xl font-bold text-center mb-10">
        Features
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">

        <div class="p-6 bg-gray-50 rounded-xl">
          <h3 class="font-bold text-xl">🛒 Online Stores</h3>
          <p class="text-gray-600 mt-2">
            Create your store instantly with full control.
          </p>
        </div>

        <div class="p-6 bg-gray-50 rounded-xl">
          <h3 class="font-bold text-xl">📦 Products</h3>
          <p class="text-gray-600 mt-2">
            Manage products, categories and inventory easily.
          </p>
        </div>

        <div class="p-6 bg-gray-50 rounded-xl">
          <h3 class="font-bold text-xl">💳 Payments</h3>
          <p class="text-gray-600 mt-2">
            Accept payments and track orders seamlessly.
          </p>
        </div>

      </div>

    </section>

    <!-- CTA -->
    <section class="py-20 bg-blue-500 text-white text-center">

      <h2 class="text-3xl font-bold">
        Start Your Store Today
      </h2>

      <p class="mt-3">
        Join hundreds of merchants using Storelio
      </p>

      <router-link
        to="/register"
        class="inline-block mt-6 bg-white text-blue-500 px-6 py-3 rounded-lg font-bold"
      >
        Create Store
      </router-link>

    </section>

  </div>
</template>