<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <h3>
              Editar Ganado de id:  {{ $route.params.id }}
            </h3>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CInput type="text" label="Name" placeholder="Name" v-model="ganado.name"></CInput>
            <CInput type="text" label="Crotal" placeholder="Crotal" v-model="ganado.crotal"></CInput>
            <CInput type="text" label="Costillar" placeholder="Costillar" v-model="ganado.costillar"></CInput>
            <CInput type="text" label="Raza" placeholder="Raza" v-model="ganado.raza"></CInput>
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
       ganado:{   
            id: null,
            name: '',
            crotal: '',
            costillar: '',
            raza: '',
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
        axios.post(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        {
            _method: 'PUT',
            name: self.ganado.name,
            crotal: self.ganado.crotal,
            costillar: self.ganado.costillar,
            raza: self.ganado.raza,
        })
        .then(function (response) {
            console.log("estoy en funcion");
            console.log(self.ganado.raza),
            self.message = 'Ganado editado con exito.';
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
    axios.get(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.ganado = response.data;
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
