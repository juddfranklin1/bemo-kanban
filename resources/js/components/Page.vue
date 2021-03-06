<template>
  <div class="page text--black">
    <h1>{{ msg }}</h1>
    <a class="btn--abs-tr-corner text--success border--success btn bg--white" href="/db-dump">
        Dump the Db
    </a>
    <button
      @click="addColumn"
      class="btn bg--success text--white button--add-column"
    >
      Add Column
    </button>
    <div class="loading flex--center" v-if="loading">
        <PacmanLoader />
    </div>
    <div v-if="!loading" class="columns">
      <transition-group tag="div" name="slide-fade" class="columns__container">
        <Column
          v-for="(column, index) in columns"
          @reloadAllCols="reloadColumns"
          @deleteColumn="removeColumn(column.id)"
          :key="'column-' + column.id"
          :id="column.id"
          :index="index"
          :cards="column.cards"
          :title="column.title"
        />
      </transition-group>
      <div class="columns__message--message" v-if="columns.length === 0">
        <p class="text--center text--danger"><b>No Columns Currently</b></p>
      </div>
    </div>
  </div>
</template>

<script>
import Column from "./Column";
import PacmanLoader from "./PacmanLoader";
import Axios from "axios";

export default {
  name: "Page",
  props: {
    msg: String
  },
  components: {
    Column,
    PacmanLoader
  },
  data() {
    const columnRequest = Axios.get("api/columns")
                            .then(response => {
                                this.columns = response.data;
                                this.loading = false;
                            });

    return {
      loading: true,
      columns: []
    };
  },
  methods: {
    addColumn() {// Add a column to the database and update component state
      const now = new Date();
      const column = {
        title: "New Column " + now.toUTCString()
      };
      Axios.post("api/columns", column)
        .then(response => {// Async update of
          this.columns.push({
          title: response.data.title,
          id: response.data.id
        });
      });
    },
    reloadColumns() {
        Axios.get("api/columns")
          .then(response => {
            this.columns = response.data
          })
    },
    removeColumn(id) {// Remove a column from the database and update component state
      Axios.delete("api/columns/" + id)
        .then(response => this.columns = this.columns.filter(col => col.id !== id))
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.border {
  &--danger {
    border: 1px solid red;
  }
  &--success {
    border: 1px solid green;
  }
  &--black {
    border: 1px solid #040404;
  }
}
.bg {
  &--danger {
    background-color: red;
  }
  &--success {
    background-color: green;
  }
}
.text {
  &--danger {
    color: red;
  }
  &--success {
    color: green;
  }
  &--white {
    color: #fdfdfd;
  }
  &--black {
    color: #040404;
  }
  &--center {
    text-align: center;
  }
}
.btn {
  font-weight: bold;
  border-radius: 4px;
  padding: 0.5rem 0.75rem;
  &--abs-tr-corner {
      position: absolute;
      top: .5rem;
      right: .5rem;
  }
}
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.columns {
  &__container {
    display: flex;
    width: 100%;
    margin: auto;
  }
  &__message--message {
      width: 100%;
      clear: both;
  }
}
</style>
