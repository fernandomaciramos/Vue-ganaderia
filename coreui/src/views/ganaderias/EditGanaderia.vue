<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <h3>
              Edit Ganaderia id:  {{ $route.params.id }}
            </h3>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CInput type="text" label="Name" placeholder="Name" v-model="ganaderia.name"></CInput>
            <CInput type="text" label="Email" placeholder="Email" v-model="ganaderia.email"></CInput>
            <CButton color="primary" @click="update()">Save</CButton>
            <CButton color="primary" @click="goBack">Back</CButton>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
    

</template>

<script>
import axios from 'axios'
export default {
  name: 'EditUser',
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  data: () => {
    return {
       ganaderia:{   
            id: null,
            name: '',
            email: '',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    update() {
        let self = this;
        console.log("estoy en update");
        axios.post(  this.$apiAdress + '/api/ganaderias/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        {
            _method: 'PUT',
            name: self.ganaderia.name,
            email: self.ganaderia.email,
        })
        .then(function (response) {
            console.log("estoy en funcion");
            console.log(self.ganaderia.name),
            self.message = 'Successfully updated user.';
            self.showAlert();
        }).catch(function (error) {
            console.log(error);
            // self.$router.push({ path: '/login' });
        });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/ganaderias/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.ganaderia = response.data;
        console.log(self.ganaderia);
        // self.email = response.data.email; 
        // console.log(self.name);
    }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
    });
  }
}


</script>
