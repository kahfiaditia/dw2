<template>
  <div class="py-4 border-bottom">
    <div class="d-flex">
      <div class="flex-shrink-0 align-self-center me-3">
        <img :src="foto" class="avatar-xs rounded-circle" alt="" />
      </div>
      <div class="flex-grow-1">
        <h5 class="font-size-15 mb-1">{{ name }}</h5>
        <p class="text-muted mb-0">
          <i class="mdi mdi-circle text-success align-middle me-1"></i>
          Active
        </p>
      </div>

      <!-- <div>
        <div class="dropdown chat-noti-dropdown active">
          <button
            class="btn dropdown-toggle"
            type="button"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="bx bx-bell bx-tada"></i>
          </button>
        </div>
      </div> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contact: [],
      name: null,
      foto: null,
    };
  },
  beforeCreate() {
    var currentUrl = window.location.pathname;
    var uri = currentUrl.split("/");
    var user_id = uri[2];

    var cek_localStorage = localStorage.getItem("userID");
    if (uri[1] == "chat") {
      if (cek_localStorage != user_id) {
        // set localStorage
        localStorage.setItem("userID", user_id);
      }
    }
  },
  mounted() {
    // get localStorage
    var user_id = localStorage.getItem("userID");
    this.loadShow(user_id);
  },
  methods: {
    async loadShow(user_id) {
      axios.get("/api/show/" + user_id).then((response) => {
        this.name = response.data.name.toUpperCase();
        if (response.data.roles == "Siswa") {
          this.foto = "/assets/images/users/avatar.png";
        } else {
          if (response.data.employee) {
            if (response.data.employee.foto) {
              this.foto =
                "/storage/karyawan/foto/" + response.data.employee.foto;
            } else {
              this.foto = "/assets/images/users/avatar.png";
            }
          } else {
            this.foto = "/assets/images/users/avatar.png";
          }
        }
      });
    },
  },
};
</script>