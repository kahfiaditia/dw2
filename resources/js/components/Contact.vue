<template>
  <div>
    <div class="py-2"></div>

    <div class="chat-leftsidebar-nav">
      <ul class="nav nav-pills nav-justified">
        <li class="nav-item">
          <a
            href="#chat"
            data-bs-toggle="tab"
            aria-expanded="true"
            class="nav-link active"
          >
            <i class="bx bx-chat font-size-20 d-sm-none"></i>
            <span class="d-none d-sm-block">Chat</span>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="#contacts"
            data-bs-toggle="tab"
            aria-expanded="false"
            class="nav-link"
          >
            <i class="bx bx-book-content font-size-20 d-sm-none"></i>
            <span class="d-none d-sm-block">Contacts</span>
          </a>
        </li>
      </ul>
      <div class="tab-content py-4">
        <div class="tab-pane show active" id="chat">
          <h5 class="font-size-14 mb-3">Recent</h5>
          <div data-simplebar style="max-height: 350px">
            <div class="mt-1">
              <ul class="list-unstyled chat-list">
                <li v-for="item in converstation" :key="item.id">
                  <router-link
                    :to="{
                      name: 'converstation',
                      params: { id: item.id },
                    }"
                  >
                    <div class="d-flex" v-if="item.user_one.id == userId">
                      <div
                        class="flex-shrink-0 align-self-center me-3"
                        v-if="item.user_two.date_login"
                      >
                        <i class="mdi mdi-circle text-success font-size-10"></i>
                      </div>
                      <div class="flex-shrink-0 align-self-center me-3" v-else>
                        <i class="mdi mdi-circle font-size-10"></i>
                      </div>
                      <div class="flex-shrink-0 align-self-center me-3">
                        <img
                          v-if="item.user_two.avatar != null"
                          :src="
                            '/storage/karyawan/foto/' + item.user_two.avatar
                          "
                          class="rounded-circle avatar-xs"
                          alt=""
                        />
                        <img
                          v-else
                          src="/assets/images/users/avatar.png"
                          class="rounded-circle avatar-xs"
                          alt=""
                        />
                      </div>

                      <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-truncate font-size-14 mb-1">
                          {{ item.user_two.name.toUpperCase() }}
                        </h5>
                        <p class="text-truncate mb-0">
                          {{ item.user_two.roles }}
                        </p>
                      </div>
                      <div class="font-size-11">
                        {{
                          item.last_chat
                            ? new Date(item.last_chat).toLocaleDateString()
                            : "-"
                        }}
                      </div>
                    </div>

                    <div class="d-flex" v-else>
                      <div
                        class="flex-shrink-0 align-self-center me-3"
                        v-if="item.user_one.date_login"
                      >
                        <i class="mdi mdi-circle text-success font-size-10"></i>
                      </div>
                      <div class="flex-shrink-0 align-self-center me-3" v-else>
                        <i class="mdi mdi-circle font-size-10"></i>
                      </div>
                      <div class="flex-shrink-0 align-self-center me-3">
                        <img
                          v-if="item.user_one.avatar != null"
                          :src="
                            '/storage/karyawan/foto/' + item.user_one.avatar
                          "
                          class="rounded-circle avatar-xs"
                          alt=""
                        />
                        <img
                          v-else
                          src="/assets/images/users/avatar.png"
                          class="rounded-circle avatar-xs"
                          alt=""
                        />
                      </div>

                      <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-truncate font-size-14 mb-1">
                          {{ item.user_one.name.toUpperCase() }}
                        </h5>
                        <p class="text-truncate mb-0">
                          {{ item.user_one.roles }}
                        </p>
                      </div>
                      <div class="font-size-11">
                        {{
                          item.last_chat
                            ? new Date(item.last_chat).toLocaleDateString()
                            : "-"
                        }}
                      </div>
                    </div>
                  </router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="tab-pane" id="contacts">
          <div class="search-box chat-search-box py-1">
            <div class="position-relative">
              <input
                type="text"
                v-model="search"
                class="form-control"
                style="border: 1px solid"
                placeholder="Search..."
                @keyup="getAllStarWarsPeople"
              />
              <i class="bx bx-search-alt search-icon"></i>
            </div>
          </div>
          <br />
          <h5 class="font-size-14 mb-3">Contacts</h5>
          <div data-simplebar style="max-height: 350px">
            <div class="mt-1">
              <ul class="list-unstyled chat-list">
                <li v-for="cont in contact" :key="cont.id">
                  <router-link :to="'/contact/' + cont.id">
                    <div class="d-flex">
                      <div
                        class="flex-shrink-0 align-self-center me-3"
                        v-if="cont.date_login"
                      >
                        <i class="mdi mdi-circle text-success font-size-10"></i>
                      </div>
                      <div class="flex-shrink-0 align-self-center me-3" v-else>
                        <i class="mdi mdi-circle font-size-10"></i>
                      </div>
                      <div class="flex-shrink-0 align-self-center me-3">
                        <img
                          v-if="cont.avatar != null && cont.roles != 'Siswa'"
                          :src="'/storage/karyawan/foto/' + cont.avatar"
                          class="rounded-circle avatar-xs"
                          alt=""
                        />
                        <img
                          v-else
                          src="/assets/images/users/avatar.png"
                          class="rounded-circle avatar-xs"
                          alt=""
                        />
                      </div>

                      <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-truncate font-size-14 mb-1">
                          {{ cont.name.toUpperCase() }} - {{ cont.email }}
                        </h5>
                        <p class="text-truncate mb-0">
                          {{ cont.roles }}
                        </p>
                      </div>
                    </div>
                  </router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contact: [],
      search: null,
      converstation: [],
      userId: null,
    };
  },
  watch: {
    $route: "loadContact",
    $route: "loadConverstation",
  },
  async mounted() {
    this.getAllStarWarsPeople();
    this.loadConverstation();
    this.loadContact();

    // import laravel-echo terlebih dahulu jika tidak bisa menggunakan windows.Echo.Channel
    window.Echo.channel("messages").listen("MessageCreated", (event) => {
      this.loadConverstation();
    });
  },
  methods: {
    async loadContact() {
      // get localStorage
      var user_id = localStorage.getItem("userID");

      await axios.get("/api/contact/" + user_id).then((response) => {
        this.contact = response.data;
      });
    },

    async loadConverstation() {
      // get localStorage
      var user_id = localStorage.getItem("userID");

      await axios.get("/api/converstation/" + user_id).then((response) => {
        this.converstation = response.data.data;
        this.userId = response.data.userId;
      });
    },

    async getAllStarWarsPeople() {
      if (this.search != "") {
        await axios.get("/api/search/" + this.search).then((response) => {
          this.contact = response.data;
        });
      } else {
        this.loadContact();
      }
    },
  },
};
</script>