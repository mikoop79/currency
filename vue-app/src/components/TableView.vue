<template>
  <div
    class="flex w-1/6 mx-auto bg-gray-800 cursor-pointer items-center justify-center m-2 px-2 py-1 text-base text-white font-medium leading-6 text-black transition duration-150 ease-in-out bg-dark border-transparent rounded-md"
    @click="doSearch"
  >
    Refresh Reports
  </div>
  <table-lite
    :has-checkbox="false"
    :is-loading="table.isLoading"
    :columns="table.columns"
    :rows="table.rows"
    :total="table.totalRecordCount"
    :messages="table.messages"
    @do-search="doSearch"
  />
</template>

<script>
import {defineComponent, reactive, ref, computed} from "vue";
import TableLite from "vue3-table-lite";
import axios from "axios";
import Auth from "../Auth";

const table = reactive({
  isLoading: false,
  isReSearch: false,
  columns: [
    {
      label: "ID",
      field: "id",
      width: "3%",
      sortable: true,
      isKey: true,
    },

    {
      label: "Name",
      field: "name",
      width: "10%",
      sortable: true,
      isKey: true,
    },

    {
      label: "Currency",
      field: "currency",
      width: "4%",
      sortable: true,
    },
    {
      label: "Date",
      field: "created_at",
      width: "10%",
    },
    {
      label: "Data",
      field: "data",
      width: "70%",
    },
  ],
  rows: [],
  totalRecordCount: 20,
  sortable: {
    order: "id",
    sort: "asc",
  },
  messages: {
    pagingInfo: "Showing {0}-{1} of {2}",
    pageSizeChangeLabel: "Row count:",
    gotoPageLabel: "Go to page:",
    noDataAvailable: "No data",
  },
});

const doSearch = (offset, limit, order, sort) => {
  table.isLoading = true;
  setTimeout(() => {
    table.isReSearch = offset == undefined ? true : false;
    if (offset >= 10 || limit >= 20) {
      limit = 20;
    }
    myReports();

  }, 1500);
};

if (Auth.user){
  doSearch();
}
const myReports = () => {
  axios.get('/api/report/my')
      .then((response) => {
        if (!response.data) {
          this.message = 'No Reports to show';
        }
        table.rows = response.data.data
        table.totalRecordCount = response.data.data.length;
        table.sortable.order = 'name';
        table.sortable.sort = 'asc';
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        table.isLoading = false;
      })
};

export default defineComponent({
  name: "App",
  components: {
    TableLite,
  },
  setup() {
    return {
      table,
      doSearch,
    };
  },
});
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
