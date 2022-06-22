<template>
  <main>
    <div class="px-4 py-6 sm:px-0">
      <div
        class="text-center"
      >
        <div v-if="hasCurrencies">
          <MyReports :currencies="myCurrencies" />
        </div>
        <div v-else>
          <h2>Please select {{ currencies_limit }} currencies to use for conversions.</h2>

          <div class="select-dropdown">
            <v-select
              v-model="selected"
              :loading="isLoading"
              placeholder="Select..."
              multiple
              :options="currencies"
              :selectable="() => selected.length < currencies_limit"
            />
            <div>Currencies Selected: {{ selected.length }}</div>
            <div> {{ message }}</div>

            <div v-show="selected.length">
              <div
                v-if="selected.length === currencies_limit"
                class="flex bg-gray-800  items-center justify-center m-2 px-8 py-1 text-base text-white font-medium leading-6 text-black transition duration-150 ease-in-out bg-dark border-transparent rounded-md focus:outline-none focus:ring md:py-4 md:text-lg md:px-10"
                @click="save"
              >
                Save my Currencies
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import {ref} from 'vue'
import Auth from '../Auth';
import axios from "axios";
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import MyReports from './MyReports'

// Data
const currencies_limit = ref(5)
const user = ref(Auth.user)
const currencies = ref([])
const myCurrencies = ref([])
const selected = ref([])
let message = ref('')
const hasCurrencies = ref(myCurrencies.value.length > 0)
const settings = ref(Auth.user.value)
const isLoading = ref(true)

// Functions / Methods
const save = () => {
  const data = {
    currencies: []
  }

  selected.value.forEach((selectCurrency) => {
    data.currencies.push(selectCurrency)
  })

  axios.post('/api/setting/store', data)
      .then((data) => {
        message.value = 'Settings Saved!.... redirecting';
        // window.location.reload(true);
        hasCurrencies.value = true;
        getMyCurrencies();
      })
      .catch((error) => {
        message.value = error.message;
      })
}
// format the data for select array
const setCurrenciesSelect = (data) => {
  const currencyKeys = Object.keys(data.currencies)

  currencyKeys.forEach((key) => {
    let item = {
      'label': data.currencies[key],
      'value': key
    }
    currencies.value.push(item)
  })
}

const getMyCurrencies = () => {
  axios.get('/api/setting/my-currencies')
      .then(({data}) => {
        if (!data) {
          message = 'No Currencies to show';
        }
        myCurrencies.value = data.data;

        hasCurrencies.value = myCurrencies.value.length > 0;
      })
      .catch((error) => {
        this.message = error
      })
}


// get a list of possible currencies to use
const getAllCurrencies = () => {
  axios.get('/api/currency/list')
      .then(({data}) => {

        if (data.message) {
          message.value = data.message;
          return;
        }

        data ? setCurrenciesSelect(data) : message.value = 'no response from list endpoint'
      })
      .catch((error) => {
        message.value = error
      })
  .finally(() => {
    isLoading.value = false;
  });
}
// get My currencies
getMyCurrencies();

if (!hasCurrencies.value) {
  getAllCurrencies();
}

</script>
