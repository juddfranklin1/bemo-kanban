<template>
  <div class="page text--black">
    <h1>{{ msg }}</h1>
    <button
      @click="addColumn"
      class="btn bg--success text--white button--add-column"
    >
      Add Column
    </button>
    <div class="columns">
      <transition-group tag="div" name="slide-fade" class="columns">
        <Column
          @deleteColumn="removeColumn"
          v-for="(column, index) in columns"
          :key="column.title"
          :id="index"
          :index="index"
          :title="column.title"
        />
      </transition-group>
      <div v-if="columns.length === 0">
        <p class="text--center text--danger"><b>No Columns Currently</b></p>
      </div>
    </div>
  </div>
</template>

<script>
import Column from "./Column";

export default {
  name: "Page",
  props: {
    msg: String
  },
  components: {
    Column
  },
  data() {
    return {
      columns: [
        {
          id: 0,
          title: "Column 1"
        },
        {
          id: 1,
          title: "Column 2"
        },
        {
          id: 2,
          title: "Column 3"
        },
        {
          id: 3,
          title: "Column 4"
        }
      ]
    };
  },
  methods: {
    addColumn() {
      this.columns.push({
        title: "Column " + (this.columns.length + 1),
        id: this.columns.length
      });
    },
    removeColumn(index) {
      this.columns.splice(index, 1);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
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
  border: 1px solid #333;
  border-radius: 4px;
  padding: 0.5rem 0.75rem;
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
  display: flex;
  width: 100%;
  margin: auto;
}
</style>
