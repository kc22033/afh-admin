<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }

    .loading {
        font-size: 36px;
        font-weight: bold;
        color: orange;
    }


</style>

<template>
    <div class="container" style="width:100%">
        <div style="width:100%">
            <div v-if="loading">
                <div class="col text-center">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <span class="loading">Loading {{working.status}} {{working.species}}s</span>
                </div>
            </div>
            <div v-else>
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-1">
                                <!-- New Button -->
                                <a :href="newURL()" data-toggle="tooltip" title="Create new animal">
                                    <i class="fa fa-plus fa-lg" aria-hidden="true" @click="newAnimal()"></i>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <select 
                                    class="form-control" 
                                    id="species"
                                    @change="onSelectSpecies($event.target.value)">
                                    <option v-for="species in speciesList" 
                                        :value="species.value" 
                                        :selected="(species.value == working.species)">
                                        {{ species.text }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select 
                                    class="form-control" 
                                    id="status"
                                    @change="onSelectStatus($event.target.value)">
                                    <option v-for="status in statusList" 
                                        :value="status.value" 
                                        :selected="(status.value == working.status)">
                                        {{ status.text }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Search ..." v-model="searchQuery"
                                data-toggle="tooltip" title="Search Name, Foster, Breed, & Date of Birth">
                            <span class="input-group-addon"><i class="fa fa-times" @click="clearSearch"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <span class="text-right">
                            {{animalList.length}} {{working.status}} {{working.species}}s&nbsp;
                            <span v-if="searchQuery">
                                /&nbsp;Filtered by Search to {{filteredData.length}}&nbsp;&nbsp;
                            </span>
                        </span>
                    </div>
                </div>
            </div>

                <div style="width:95%">
                    <!-- Animals -->
                    <table v-if="animalList" class="table table-borderless table-striped table-hover table-condensed m-b-none">
                        <thead>
                            <tr>
                                <th>Sel<br></th>
                                <th>Name<br></th>
                                <th>Foster</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Breed</th>
                                <th>ID<br></th>
                                <th>Del</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="item in filteredData">
                                <!-- Select -->
                                <td style="vertical-align: middle;">
                                    <input type="checkbox" :id="item.id" :value="item.id" v-model="selectList">
                                </td>

                                <!-- Name -->
                                <td style="vertical-align: middle;">
                                    <a :href="editURL(item)" :title="editTip(item)">
                                    {{ item.name }}
                                    </a>
                                </td>

                                <!-- Breed(s) -->
                                <td style="vertical-align: middle;">
                                    {{ item.foster }}
                                </td>

                                <!-- Gender -->
                                <td style="vertical-align: middle;">
                                    {{ item.gender }}
                                </td>

                                <!-- DOB -->
                                <td style="vertical-align: middle; width: 7em;">
                                    {{ dateOfBirth(item.date_of_birth) }}
                                </td>

                                <!-- Breed -->
                                <td style="vertical-align: middle;">
                                    {{ item.breed }}
                                </td>

                                <!-- Id -->
                                <td style="vertical-align: middle;">
                                    {{ item.id }}
                                </td>

                                <!-- Edit Button -->
                                <td style="vertical-align: middle; width: 4em;">
                                    <a href="#" :title="deleteTip(item)">
                                        <i class="fa fa-trash-o fa-lg" aria-hidden="true" @click="confirmDelete(item)"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="vertical-align: bottom;">
                                <td>&nbsp;</td>
                                <td colspan="7">
                                    <div class="container">
                                        <div class="form-inline">
                                            <div class="col-md-3">
                                                {{ selectList.length }} Selected -  
                                                <strong>Change Status to:</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <select 
                                                    class="form-control" 
                                                    id="new-status"
                                                    @change="onSelectNewStatus($event.target.value)">
                                                    <option v-for="status in statusList" 
                                                        :value="status.value" 
                                                        :selected="(status.value == newStatus.value)">
                                                        {{ status.text }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <button @click="updateStatus">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div v-else>
                        No Records Found
                    </div>
                </div>
        </div>
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="deleteModalTitle"><strong>Confirm Delete</strong></h5>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete the record for <span id="theDog"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" @click="destroyAnimal()">Yes</button>
              </div>
            </div>
          </div>
        </div>  
    </div>
</template>

<script>
    import toastr from 'toastr'

    export default {
        name: 'afh-animals',

        components: {
        },
        
        /*
         * The component's data.
         */
        data: function() {
            return {
                working: {
                    species: 'Dog',
                    status: 'Available',
                    targetStatus: 'Adopted',
                },
                editId: '',
                animalToDelete: {},
                ready: false,
                searchQuery: '',
                selectList: [],
                statusList: [],
                speciesList: [],
                animal: {},
                animalList: [{}]
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            var _ = require('lodash');
            this.prepareComponent();
            this.ready = true;
        },

        computed: {
            filteredData() {
                var filterKey = "" + this.searchQuery.toLowerCase()
                var data = this.animalList
                if (filterKey) {
                    data = data.filter(function (row) {
                        return (
                            (
                                (String(row['name']).toLowerCase().indexOf(filterKey) > -1) ||
                                (String(row['foster']).toLowerCase().indexOf(filterKey) > -1) ||
                                (String(row['date_of_birth']).toLowerCase().indexOf(filterKey) > -1) ||
                                (String(row['breed']).toLowerCase().indexOf(filterKey) > -1) 
                            )
                        )
                    })
                }   
                return data;        
            },

            loading() {
                return (!this.ready);
            },

            currStatus() {
                var status = {
                    value: this.working.status,
                    text: this.working.status
                }
                return status;
            },

            currSpecies() {
                var species = {};

                var value = this.animal.species || "Dog";

                species.value = value;
                species.text = value;
            
                return species;
            },

            newStatus() {
                var status = {};

                var value = this.working.targetStatus || "Adopted";

                status.value = value;
                status.text = value;
            
                return status;
            }
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getStatuses();
                this.getSpecies();
                this.getAnimals();
                this.$nextTick(function () {
                    $('[data-toggle="tooltip"]').tooltip(); 
                });
            },

            str_pad(n) {
                return String("00" + n).slice(-2);
            },

            clearSearch() {
                this.searchQuery = "";
            },

            /**
             * Get list of available status values
             */
            getStatuses() {
                window.axios.get('/api/status')
                    .then(response => {
                        this.statusList = response.data;
                    });
            },

            /**
             * Get list of available species values
             */
            getSpecies() {
                window.axios.get('/api/species')
                    .then(response => {
                        this.speciesList = response.data;
                    });
            },

            /**
             * Get all of the animals
             */
            getAnimals() {
                this.ready = false;
                this.animalList = {};
                window.axios.get('/api/animals', {
                    params: { species: this.working.species, status: this.working.status, orderBy: 'name', sortOrder: 'asc' }})
                    .then(response => {
                        this.animalList = response.data;
                        this.ready = true;
                    });
            },

            dateOfBirth(date) {
                if(!date) return "";
                var d = new Date(date);
                return (d.getFullYear()) + "-" + this.str_pad(d.getMonth() + 1) + "-" + this.str_pad(d.getDate());
            },
            /**
             * Edit animal
             * Return the edit URL for the current animal
             */
            editURL(animal) {
                return "/animals/edit?id=" + animal.id + "&species=" + this.working.species;  
            },

            /**
             * Edit animal
             * Return the edit tooltip for the current animal
             */
            editTip(animal) {
                return "Edit " + animal.name;  
            },

            editAnimal(animal) {
                window.axios.get('/animals/edit', {params: { id: animal.id, species: this.working.species }})
            },

            /**
             * New animal
             */
            newURL() {
                return "/animals/edit?id=0&species=" + this.working.species;  
            },

            newAnimal() {
                window.axios.get('/animals/edit', {params: { id: 0, species: this.working.species }})
            },

            /**
             * Find in array
             */
            findAnimal(id) {
                let animal = _.find(this.animalList, {id});
                return animal;
            },

 
            /**
             * Delete animal
             * Return the edit tooltip for the current animal
             */
            deleteTip(animal) {
                return "Delete " + animal.name;  
            },

            /**
             * Confirm that the user really wants to delete the record
             */
            confirmDelete(animal) {
                this.animalToDelete = animal;
                $('#deleteModal').modal('show');
                $('#theDog').html('<strong>' + this.animalToDelete.name + '</strong>');
            },

           /**
             * Delete an animal
             */
            destroyAnimal() {
                $('#deleteModal').modal('hide');
                var self = this;
                window.axios.delete('/api/animals/' + this.animalToDelete.id)
                    .then(
                        (response) => {
                            toastr.success(this.animalToDelete.name + ' successfully deleted!');
                            self.animalList.splice(this.animalList.indexOf(this.animalToDelete), 1);
                        },
                        (error) => {
                            toastr.error(this.animalToDelete.name + ' delete failed!');
                            alert('Unable to delete animal ' + this.animalToDelete.name + '!');
                        }
                    );
            },

            onSelectStatus(value) {
                this.working.status = value
                this.getAnimals();
            },

            onSelectNewStatus(value) {
                this.$set(this.working, 'targetStatus', value);
            },

            onSelectSpecies(value) {
                this.$set(this.species, 'targetStatus', value);
                this.getAnimals();
            },

            /**
             * Update status for selected animals
             */
            updateStatus() {
                if (this.working.status == this.working.targetStatus) return;
                var self = this;
                for (var i = 0, len = this.selectList.length; i < len; i++) {
                    var id = this.selectList[i];
                    var animal = this.findAnimal(id);
                    animal.selected = false;
                    window.axios.put('/api/animals/updateStatus/' + id, {status: this.working.targetStatus })
                        .then((response) => {
                            toastr.success(response.data.name + ' updated successfully!');
                            self.animalList.splice(this.animalList.indexOf(animal), 1);
                        }, (response) => {
                            toastr.error(animal.name + ' Update Failed!');
                        }
                    )
                }
                this.selectList = [];
            }
        }
    }
</script>
