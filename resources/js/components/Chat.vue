<template>
  <div>
    <div class="card">
      <div class="p-4 border-bottom">
        <div class="row">
          <div class="col-md-4 col-9">
            <h5 class="font-size-15 mb-1">{{ name }}</h5>
            <p class="text-muted mb-0" v-if="userTwo.date_login != null">
              <i class="mdi mdi-circle text-success align-middle me-1"></i>
              Active now
            </p>
            <p class="text-muted mb-0" v-else>
              <i class="mdi mdi-circle align-middle me-1"></i>
              {{
                userTwo.date_logout
                  ? new Date(userTwo.date_logout).toLocaleString("en-GB")
                  : "-"
              }}
            </p>
          </div>
        </div>
      </div>
      <div>
        <div class="chat-conversation p-3">
          <ul
            class="list-unstyled mb-0"
            data-simplebar
            style="max-height: 490px"
          >
            <div v-if="message.length > 0">
              <div v-for="item in message" :key="item.id">
                <li v-if="item.user.id != userId">
                  <div class="conversation-list">
                    <div class="dropdown"></div>
                    <div class="ctext-wrap">
                      <div class="conversation-name">
                        {{ item.user.name.toUpperCase() }}
                      </div>
                      <p>{{ item.body }}</p>
                      <p class="chat-time mb-0">
                        <i class="bx bx-time-five align-middle me-1"></i>
                        {{ new Date(item.created_at).toLocaleString("en-GB") }}
                      </p>
                    </div>
                  </div>
                </li>
                <li v-else-if="item.user.id == userId" class="right">
                  <div class="conversation-list">
                    <div class="dropdown">
                      <a
                        class="dropdown-toggle"
                        href="#"
                        role="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                        @click="deleteMessage(item.id)"
                      >
                        <i class="bx bx-trash text-danger"></i>
                      </a>
                    </div>
                    <div class="ctext-wrap">
                      <div class="conversation-name">
                        {{ item.user.name.toUpperCase() }}
                      </div>
                      <p>{{ item.body }}</p>
                      <p class="chat-time mb-0">
                        <i class="bx bx-time-five align-middle me-1"></i>
                        {{ new Date(item.created_at).toLocaleString("en-GB") }}
                      </p>
                    </div>
                  </div>
                </li>
              </div>
            </div>
            <div v-else>
              <li>
                <div class="chat-day-title">
                  <span class="title">Today</span>
                </div>
              </li>
            </div>

            <li ref="last"></li>
          </ul>
        </div>
        <div class="p-3 chat-input-section">
          <form @submit.prevent="simpanData()">
            <div class="row">
              <div class="col">
                <div class="position-relative">
                  <input
                    v-model="form.body"
                    type="text"
                    class="form-control chat-input"
                    placeholder="Enter Message..."
                  />
                </div>
              </div>
              <div class="col-auto">
                <button
                  type="submit"
                  class="
                    btn btn-primary btn-rounded
                    chat-send
                    w-md
                    waves-effect waves-light
                  "
                  :disabled="disabled"
                >
                  <i v-show="loading" class="bx bx-loader-circle bx-spin"></i>
                  <span class="d-none d-sm-inline-block me-2">Send</span>
                  <i class="mdi mdi-send"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Echo from "laravel-echo";

export default {
  props: ["id"],
  data() {
    return {
      userTwo: [],
      message: [],
      name: null,
      status: null,
      userId: null,
      form: new Form({
        body: "",
      }),
      last: null,
      loading: false,
      disabled: false,
    };
  },
  watch: {
    $route: "getUsers",
  },
  mounted() {
    // import laravel-echo terlebih dahulu jika tidak bisa menggunakan windows.Echo.Channel
    window.Echo.channel("messages").listen("MessageCreated", (event) => {
      this.getUsers();
    });

    this.getUsers();
  },
  methods: {
    getUsers() {
      // get localStorage
      var me = localStorage.getItem("userID");
      this.userId = me;

      axios
        .get("/api/message_converstation/" + this.id + "/" + me)
        .then((response) => {
          // header chat user two
          this.name = response.data.user.name.toUpperCase();
          this.userTwo = response.data.user;

          // body message
          this.message = response.data.message;
        });
    },

    simpanData() {
      // get localStorage
      var me = localStorage.getItem("userID");

      (this.loading = true), (this.disabled = true);

      this.form
        .post("/api/store/" + this.id + "/" + me)
        .then((response) => {
          if (response.data.code == 200) {
            this.getUsers();

            (this.loading = false), (this.disabled = false);

            this.form.body = "";

            Toast.fire({
              icon: "success",
              title: "Berhasil dikirim",
            });
          } else {
            (this.loading = false), (this.disabled = false);
          }
        })
        .catch(() => {
          Toast.fire({
            icon: "error",
            title: "Gagal dikirim",
          });
          (this.loading = false), (this.disabled = false);
        });

      this.$refs["last"].scrollIntoView({ behavior: "auto", block: "end" });
    },

    deleteMessage(id) {
      Swal.fire({
        title: "Hapus Data",
        text: "Ingin menghapus data?",
        icon: "question",
        showCancelButton: true,
        showCloseButton: true,
        focusConfirm: false,
        confirmButtonColor: "#7367f0",
        cancelButtonColor: "#6e7d88",
        confirmButtonText: "Ok",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form
            .delete("/api/destroy_message/" + id)
            .then((response) => {
              if (response.data.code == 200) {
                this.getUsers();
                Swal.fire("Berhasil", "Berhasil dihapus.", "success");
              } else {
                Toast.fire({
                  icon: "error",
                  title: "Gagal dihapus",
                });
              }
            })
            .catch(() => {
              Toast.fire({
                icon: "error",
                title: "Gagal dihapus",
              });
            });
        }
      });
    },
  },
  updated() {
    this.$refs["last"].scrollIntoView({ behavior: "auto", block: "end" });
  },
};
</script>