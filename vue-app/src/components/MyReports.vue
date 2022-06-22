<template>
  <div>
    <h2 class="heading2">
      Generate report
    </h2>
    <div class="select-dropdown">
      <v-select
        v-model="selected"
        :loading="reportTypesLoading"
        :options="reportTypes"
      />
      <v-select
        v-model="report.currency"
        :loading="currenciesLoading"
        :options="currencies"
      />
      <div
        class="submitReport flex bg-gray-800  cursor-pointer items-center justify-center m-2 px-8 py-1 text-base text-white font-medium leading-6 text-black transition duration-150 ease-in-out bg-dark border-transparent rounded-md focus:outline-none focus:ring md:py-4 md:text-lg md:px-10"
        @click="saveReport"
      >
        Generate
      </div>
      <div>{{ message }}</div>
    </div>
    <h2 class="heading2">
      My Completed reports
    </h2>
    <table-view2 />
    <hr>
  </div>
</template>

<script>
import {defineComponent} from "vue";
import axios from "axios";
import Auth from "@/Auth";
import vSelect from 'vue-select';
import TableView2 from './TableView';

const default_report_type = 'Select a report type..';
const default_currency_type = 'Select a currency..';
export default defineComponent({
  name: 'MyReports',
  components: {
    vSelect,
    TableView2
  },
  props: {
    currencies: {
      type: [Array],
      default: function(){

      },
    }

  },
  data: () => ({
    auth: Auth,
    //currencies: [],
    message: '',
    reportsMessage: '',
    selected: default_report_type,
    reportTypes: [],
    user: {},
    report: {
      currency: default_currency_type,
      type: 1,
    },
    currenciesLoading: true,
    reportTypesLoading: true,
  }),
  created() {
    this.getReportTypes();

  },
  methods: {

    saveReport() {
      axios.post('/api/report/submit', {
        currency: this.report.currency.value,
        type: this.selected.value,
      })
          .then(({data}) => {

            if (!data) {
              this.message = 'error';
            }

            this.message = data.message;

            let _this = this;
            setTimeout(function () {
              _this.refreshGenerateForm()
            }, 3000)

          })
          .catch((error) => {
            this.message = error
          })
    },
    getReportTypes() {
      axios.get('/api/report-types')
          .then(({data}) => {

            if (!data) {
              this.message = 'No Reports to show';
            }
            this.reportTypes = data;
            this.reportTypesLoading = false;
            this.currenciesLoading = false;
          })
          .catch((error) => {
            this.message = error
          })
    },

    refreshGenerateForm() {
      this.report.currency = default_report_type;
      this.selected = default_currency_type;
      this.message = '';
    }
  }
})
</script>