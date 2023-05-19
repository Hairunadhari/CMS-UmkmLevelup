<template>
  <div class="mx-auto w-full">
    <div class="mx-auto mt-10 mb-10">
      <div class="mx-auto max-w-2xl lg:text-center">
        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Daftar Level
        </p>
      </div>
    </div>
    <table class="container mx-auto table-auto">
      <thead>
        <tr>
          <th class="px-4 py-2">
            No
          </th>
          <th class="px-4 py-2">
            Level
          </th>
          <th class="px-4 py-2">
            Aksi
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-4 py-2">
            Intro to CSS
          </td>
          <td class="border px-4 py-2">
            Adam
          </td>
          <td class="border px-4 py-2">
            858
          </td>
        </tr>
        <tr class="bg-gray-100">
          <td class="border px-4 py-2">
            A Long and Winding Tour of the History of UI Frameworks and Tools and the Impact on Design
          </td>
          <td class="border px-4 py-2">
            Adam
          </td>
          <td class="border px-4 py-2">
            112
          </td>
        </tr>
        <tr>
          <td class="border px-4 py-2">
            Intro to JavaScript
          </td>
          <td class="border px-4 py-2">
            Chris
          </td>
          <td class="border px-4 py-2">
            1,280
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'SetLevelForm',
  components: { }
}
</script>
