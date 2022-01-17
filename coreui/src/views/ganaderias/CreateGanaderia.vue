<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h3>
            Añadir Ganaderia
          </h3>
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>

          <CInput label="Nombre" type="text" placeholder="Name" v-model="ganaderia.name" valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorvacio"></CInput> 
          <CInput label="Email" type="text" placeholder="Email" v-model="ganaderia.email" valid-feedback="Thank you :)"
                invalid-feedback="Introduce un e-mail"
                :is-valid="validateEmail"></CInput>
          <CButton color="primary" @click="store()">Crear</CButton>
          <CButton color="primary" @click="goBack">Volver</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'CreateGanaderia',
  /*
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  */
  data: () => {
    return {
        ganaderia: {
          name: '',
          email:'',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
        showDismissibleAlert: false
    }
  },
  methods: {
    validatorvacio (val){
      return val ? val.length >= 1: false
    },
    validateEmail(val) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val)) {
          return true;
      } else {
          return false;
      }
    },
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    store() {
        let self = this;
        console.log(self);
        axios.post(  this.$apiAdress + '/api/ganaderias?token=' + localStorage.getItem("api_token"),
          {
            name: self.ganaderia.name,
            email: self.ganaderia.email,
          }
        )
        .then(function (response) {
            self.note = {
              title: '',
              content: '',
              applies_to_date: '',
              status_id: null,
              note_type: '',
            };
            self.message = 'Successfully created ganaderia.';
            self.showAlert();
        }).catch(function (error) {
            console.log('estoy catch del create');
            if(error.response.data.message == 'The given data was invalid.'){
              self.message = '';
              for (let key in error.response.data.errors) {
                if (error.response.data.errors.hasOwnProperty(key)) {
                  self.message += error.response.data.errors[key][0] + '  ';
                }
              }
              self.showAlert();
            }else{
              console.log(error);
              console.log('estoy en el else del catch');
              self.$router.push({ path: 'login' }); 
            }
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
    axios.get(  this.$apiAdress + '/api/ganaderias/store?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.statuses = response.data;
    }).catch(function (error) {
        console.log(error);
        console.log('store dentro del catch');
        self.$router.push({ path: 'login' });
    });
  }
}

</script>
