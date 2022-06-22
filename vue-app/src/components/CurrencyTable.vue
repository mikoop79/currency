<template>
  <div v-if="liveData">
    <div class="flex flex-col">
      <div class="text-left ">
        Live Currency Rates for your select currencies.
      </div>
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
          <div class="overflow-hidden">
            <table class="min-w-full">
              <thead class="border-b">
                <tr>
                  <th
                    scope="col"
                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                  >
                    Source
                  </th>
                  <th
                    scope="col"
                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                  >
                    Currency
                  </th>
                  <th
                    scope="col"
                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                  >
                    Conversion Rate
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(item) in liveData"

                  :key="item.id"
                  class="border-b"
                >
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-left">
                    {{ item.source }}
                  </td>

                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-left">
                    {{ item.currency }}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-left">
                    {{ item.amount }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
      name: 'CurrencyTable',
      props: {
        liveData: {
          type: [Array],
          default: function () {
            return []
          }
        }
      }
    }
);
</script>
