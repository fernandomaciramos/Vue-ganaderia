<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <h3>
              Añadir Ganado a la ganaderia con id:  {{ $route.params.id }}
            </h3>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CInput type="text" label="Nombre" placeholder="Name" v-model="ganado.name" valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorvacio"></CInput>
            <CInput type="text" label="Crotal" placeholder="Crotal" v-model="ganado.crotal" valid-feedback="Thank you :)"
                invalid-feedback="Introduce un crotal de 4 carácteres"
                :is-valid="validatorcrotal"></CInput>
            <CInput type="text" label="Costillar" placeholder="Costillar" v-model="ganado.costillar"
            valid-feedback="Thank you :)"
                invalid-feedback="Introduce un costillar de 4 carácteres"
                :is-valid="validatorcrotal"></CInput>
            <CInput type="text" label="Raza" placeholder="Raza" v-model="ganado.raza" valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorvacio"></CInput>
            <CInput type="bigint" label="Ganaderia Id" placeholder="Ganaderia" v-model="ganado.ganaderia_id" readonly></CInput>
            <CButton color="primary" @click="store()">Save</CButton>
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
            costillar:'',
            raza:'',
            ganaderia_id:'',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
    }
  },
  methods: {
    validatorcrotal (val) {
      return val ? val.length >= 4 : false
    },
    validatorvacio (val){
      return val ? val.length >= 1: false
    },
    
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    // update() {
    //     let self = this;
    //     console.log("estoy en update");
    //     axios.post(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
    //     {
    //         _method: 'PUT',
    //         name: self.ganado.name,
    //         crotal: self.ganado.crotal,
    //         ganaderia_id: self.ganado.ganaderia_id,
    //     })
    //     .then(function (response) {
    //         console.log("estoy en funcion");
    //         console.log(self.ganado.ganaderia.id),
    //         self.message = 'Successfully updated user.';
    //         self.showAlert();
    //     }).catch(function (error) {
    //         console.log(error);
    //         // self.$router.push({ path: '/login' });
    //     });
    // },
    store() {
        let self = this;
        console.log(self);
        axios.post(  this.$apiAdress + '/api/ganados?token=' + localStorage.getItem("api_token"),
          {
            name: self.ganado.name,
            crotal: self.ganado.crotal,
            costillar: self.ganado.costillar,
            raza: self.ganado.raza,
            ganaderia_id:self.ganado.ganaderia_id,
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
            self.message = 'Ganado añadido con exito.';
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
    axios.get(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.ganado.ganaderia_id = self.$route.params.id;
        console.log(self.ganado);
        // self.email = response.data.email; 
        // console.log(self.name);
    }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
    });
  }
}


</script>
