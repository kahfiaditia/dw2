<template>
  <div>
    <div class="card">
      <div class="p-4 border-bottom">
        <div class="col-xl-12 col-sm-6">
          <div class="card text-center">
            <div class="card-body">
              <div class="mb-4">
                <img
                  class="rounded-circle avatar-xxl"
                  :src="foto"
                  alt=""
                  height="50%"
                  width="50%"
                />
              </div>
              <h5 class="font-size-15 mb-1">
                <a href="javascript: void(0);" class="text-dark">{{ name }}</a>
              </h5>
              <p class="text-muted">{{ data.roles }}</p>
            </div>
            <div class="card-footer bg-transparent border-top">
              <div class="contact-links d-flex font-size-20">
                <div class="flex-fill">
                  <a href="javascript: void(0);" @click="chat_profile(data.id)"
                    ><i class="bx bx-message-square-dots"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      data: [],
      name: null,
      foto: null,
    };
  },
  watch: {
    $route: "loadShow",
  },
  async mounted() {
    this.loadShow();
  },
  methods: {
    async loadShow() {
      axios.get("/api/show_description/" + this.id).then((response) => {
        this.data = response.data;
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

    async chat_profile(id) {
      // get localStorage
      var user_id = localStorage.getItem("userID");
      await axios
        .get("/api/add_converstation/" + id + "/" + user_id)
        .then((response) => {
          this.$router.push({ path: "/converstation/" + response.data });
        });
    },
  },
};
</script>