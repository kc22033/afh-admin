<style scoped>
	.ql-container .ql-editor {
		min-height: 10em;
		padding-bottom: 1em;
		max-height: 15em;
		background-color: white;
	}
	.dropzone {
		max-height: 70px;
		padding: 2px;
	}
	input#intake-date {
		border: none !important;
		border-style: none;
	}
	.quill-editor {
		background-color: white;
	}
	img.fullsize {
		position: fixed;
		left: 50%;
		margin-left: -400px;
		top: 100px;
	}
</style>

<template>
	<div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group-lg">
					<h3>{{ animal.species }} <span class="glyphicon icon-dog"></span>: {{ animal.name }}</h3>
                </div>
            </div>
			<div v-if="animalId" class="col-md-2-sm">
				<div class="form-group text-right">
					<span class="align-baseline">AFH ID: {{ animalId }}</span><br />
					<span class="align-baseline">RescueGroups.org ID: {{ animal.rescue_groups_id }}</span>
                </div>
            </div>
			<div v-else class="col-md-2-sm">
				<div class="form-group text-right">
					<span class="align-baseline">New {{ animal.species }}</span>
                </div>
            </div>
        </div>
        <hr>

<!-- Row 1 :: Species / Pri-breed / Sec-breed / Mix / Date of Birth -->

		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label for="species">Species:</label>
					<select 
						class="form-control" 
						id="species"
						@change="$set(animal, 'species', $event.target.value)">
						<option v-for="species in speciesList" :value="species.value" :selected="(species.value == animal.species)">
							{{ species.text }}
						</option>
					</select>
                </div>
            </div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="pri-breed">Primary Breed:</label>
					<select 
						class="form-control" 
						id="pri_breed"
						@change="$set(animal, 'pri_breed', $event.target.value)">
						<option value=""></option>
						<option v-for="breed in breedList" :value="breed.value" :selected="(breed.value == animal.pri_breed)">
							{{ breed.text }}
						</option>
					</select>
                </div>
            </div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="sec-breed">Secondary Breed:</label>
					<select 
						class="form-control" 
						id="sec_breed"
						@change="$set(animal, 'sec_breed', $event.target.value)">
						<option value=""></option>
						<option v-for="breed in breedList" :value="breed.value" :selected="(breed.value == animal.sec_breed)">
							{{ breed.text }}
						</option>
					</select>
                </div>
            </div>
			<div class="col-md-2">
				<div class="checkbox">
					<br />
					<input 
						type="checkbox" 
						id="mix" 
						v-model="animal.mix">
					<strong>Mix</strong>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<div id="date-of-birth-div">
						<label for="date-of-birth">Date of Birth:</label>
						<input type="text" id="date-of-birth" v-model="animal.date_of_birth">
						<!-- <datepicker v-model="animal.date_of_birth"></datepicker> -->
					</div>
				</div>
			</div>
		</div>

<!-- Row 2 :: Name / Gender / Altered / Status / Intake Date -->

		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label" for="name">Name:</label>
					<input class="form-control" type="text" id="name" v-model="animal.name" placeholder="Name">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="gender">Gender:</label>
					<select 
						class="form-control" 
						id="gender"
						@change="$set(animal, 'sex', $event.target.value)">
						<option v-for="gender in genderList" :value="gender.value" :selected="(gender.value == animal.sex)">
							{{ gender.text }}
						</option>
					</select>
                </div>
            </div>
			<div class="col-md-1">
				<div class="checkbox">
					<br />
					<input type="checkbox" id="altered" v-model="animal.altered">
					<strong> Altered</strong>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="status">Status:</label>
					<select 
						class="form-control" 
						id="status"
						@change="$set(animal, 'status', $event.target.value)">
						<option v-for="status in statusList" :value="status.value" :selected="(status.value == animal.status)">
							{{ status.text }}
						</option>
					</select>
 				</div>
            </div>
			<div class="col-md-2">
				<div class="form-group">
					<label class="form-label" for="tagnum">AFH Tag:</label>
					<input class="form-control" type="text" id="tagnum" v-model="animal.tagnum" placeholder="AFH Tag #">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="intake-date">Intake Date:</label>
					<input type="text" id="intake-date" v-model="animal.intake_date">
					<!-- <datepicker v-model="animal.intake_date"></datepicker> -->
				</div>
			</div>
		</div>

<!-- Row 3 :: Foster / Origin / Origin ID / VA Releasing Agency / AFH Tag # -->

		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label" for="foster">Foster:</label>
					<input class="form-control" type="text" id="foster" v-model="animal.foster" placeholder="Foster">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label class="form-label" for="color">Color:</label>
					<input class="form-control" type="text" id="color" v-model="animal.color" placeholder="Color">
				</div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label class="form-label" for="weight">Weight:</label>
					<input class="form-control" type="number" id="weight" v-model.number="animal.weight" placeholder="Weight">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label class="form-label" for="origin">Origin:</label>
					<input class="form-control" type="text" id="origin" v-model="animal.origin" placeholder="Origin">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label class="form-label" for="origin-id">Origin ID:</label>
					<input class="form-control" type="text" id="origin-id" v-model="animal.origin_id" placeholder="Origin ID">
				</div>
			</div>
			<div class="col-md-2">
				<div class="checkbox">
					<br />
					<input 
						type="checkbox" 
						id="is-va-releasing-agency" 
						v-model="animal.is_va_releasing_agency">
					<strong 
						data-toggle="tooltip" 
						title="Origin is a Virginia Releasing Agency">
						VA Rel Agency
					</strong>
				</div>
			</div>
		</div>

<!-- Row 4 -->

		<div class="row">
			<div class="col-md-9">
				<div class="form-group">
					<label class="form-label" for="editor">Narrative Description:</label><br />
					<quill-editor 
						v-model="animal.narrative"
						:config="editorOption"
						ref="myTextEditor"
						theme="snow"
						style="min-height:10em;">	
					</quill-editor>
				</div>
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-danger" @click="goBack()">
							Cancel
						</button>
						<button type="button" class="btn btn-info" @click="onClone()">
							Save &amp; Clone
						</button>
						<button type="button" class="btn btn-primary" @click="onSave()">
							Save
						</button>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<label class="form-label" for="myVueDropzone">Image Upload</label>
				<dropzone 
					ref="myDropzoneRef"
					id="myVueDropzone" 
					url="/upload" 
					acceptedFileTypes="image/*"
					:headers="myDZHeaders"
					:useFontAwesome=true
					:thumbnailWidth=200
					:maxFileSizeInMB="maxUploadSizeInMB"
					@vdropzone-success="uploadDone">
				</dropzone>
				<p class="help-block" id="image-help">
					Click or drop files above to upload. Image files should be at least 800px wide and may be up to {{maxUploadSizeInMB}}MB.
				</p>
				<div style="text-align:center;margin-top:5px;">
					<img :src="fullSize" class="fullsize" v-show="showLarge"  @mouseleave="mouseLeave"/>
					<img :src="thumbNail" @mouseover="mouseOver" @mouseleave="mouseLeave"/>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
    import toastr from 'toastr'
	import { quillEditor } from 'vue-quill-editor'
	import Dropzone from 'vue2-dropzone'
	import datepicker from 'vue-date'

    export default {
        name: 'afh-animal-edit',

    	components: {
		    quillEditor,
			Dropzone,
			datepicker
		},
		  
        props: {
        	edit_id: {
        		type: [Number, String]
        	}
        },
        data: function() {
            return {
            	dateFormat: 'MM-dd-yyyy',
	        	speciesList: [],
	            breedList: [],
	            genderList: [],
	            statusList: [],
	            animal: {},
	            animalId: this.edit_id,
	            intake_date: new Date(),
	            editorInitialized: false,
	            isClone: false,
				maxUploadSizeInMB: 4,
				showLarge: false,
	            editorOption: {
	           		modules: {
			            toolbar: [
			              ['bold', 'italic', 'underline', 'strike'],
			              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
			              [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
			              [{ 'color': [] }, { 'background': [] }],
			              [{ 'font': [] }],
			              [{ 'align': [] }],
			              ['link', 'image'],
			              ['clean']
			            ]
		          }
	            }
	        };
        },
        mounted() {
			this.$nextTick(function () {
		    	// code that assumes this.$el is in-document
	        	this.getStatuses();
	            this.getSpecies();
	            this.getGenders();
				this.getBreeds();
			});
			this.getSelectedAnimal();
			$('[data-toggle="tooltip"]').tooltip(); 
			// $("#date-of-birth").datepicker().on(
			// 	"changeDate", () => {this.animal.date_of_birth = $('#date-of-birth').val()}
			// );
			// $("#intake-date").datepicker().on(
			// 	"changeDate", () => {this.animal.date_of_birth = $('#intake-date').val()}
			// );
		},
		computed: {
			editor() {
		      	return this.$refs.myTextEditor.quillEditor
		    },
		    myDZHeaders() {
		    	return ({ 'X-CSRF-TOKEN': window.Laravel.csrfToken });
			},
			thumbNail() {
				if (!this.animal.image_file) {
					return (encodeURI('/storage/images/thumbnails/comingsoon.jpg'));
				}
				return (encodeURI('/storage/images/thumbnails/' + this.animal.image_file));
			},
			fullSize() {
				if (!this.animal.image_file) {
					return (encodeURI('/storage/images/thumbnails/comingsoon.jpg'));
				}
				return (encodeURI('/storage/images/large/' + this.animal.image_file));
			},
			dateOfBirth() {
				var d = new Date(String(this.animal.date_of_birth).substr(0,10));
				var mD = d.getFullYear() + "-" + this.str_pad(d.getMonth() + 1) + "-" + this.str_pad(d.getDate() + 1);
				return mD;
			},
			intakeDate() {
				var d = new Date(String(this.animal.intake_date).substr(0,10));
				var mD = d.getFullYear() + "-" + this.str_pad(d.getMonth() + 1) + "-" + this.str_pad(d.getDate() + 1);
				return mD;
			},
			minDate() {
				var d = new Date();
				var mD = (d.getFullYear()-25) + "-" + this.str_pad(d.getMonth() + 1) + "-" + this.str_pad(d.getDate());
				return mD;
			},
			maxDate() {
				var d = new Date();
				var mD = (d.getFullYear()+1) + "-" + this.str_pad(d.getMonth() + 1) + "-" + this.str_pad(d.getDate());
				return mD;
			},
			currSpecies() {
				var species = {};

				var value = this.animal.species || "Dog";

				species.value = value;
				species.text = value;
			
				return species;
			},
			sex() {
				var sex = {
					value: this.animal.sex,
					text: this.animal.sex
				}
				return sex;
			}
		},
        methods: {
        	str_pad(n) {
			    return String("00" + n).slice(-2);
			},
			mouseOver: function(){
				this.showLarge = !this.showLarge;   
			},
			mouseLeave: function(){
				this.showLarge = false;   
			},
        	uploadDone(file, response) {
        		this.animal.image_file = response;
				this.$refs.myDropzoneRef.removeAllFiles();
				document.getElementById("image-help").innerText = "New image being optimized. Will be visible on save.";
        	},
        	close: function () {
        		this.animal = {};
        		this.show = false;
        	},
        	goBack() {
			    window.location.href = '/animals';
			},
			onDateChange() {
				this.$set(this.animal, 'intake_date', "2002-09-11");
			},
			onSave() {
				this.isClone = false;
				this.saveEdits();
			},
        	saveEdits: function () {
				var name = this.animal.name;
				var that = this;
				this.animal.date_of_birth = $('#date-of-birth').val();
				this.animal.intake_date = $('#intake-date').val();
				this.animal.is_va_releasing_agency = this.animal.is_va_releasing_agency || false;
				this.animal.mix = this.animal.mix || false;
				this.animal.altered = this.animal.altered || false;
                window.axios.put('/api/animals/' + this.animal.id, this.animal)
                    .then(
                        response => {
                            toastr.success(name + ' edited successfully!');
                            that.getSelectedAnimal();
                            window.setTimeout(function(){
                            	if(!that.isClone) {
		                            that.goBack();
		                        }
                            }, 1500)
                        },
                        error => {
                            toastr.error(name + ' edit failed!');
                        }
                    );
			},

			onClone() {
				this.isClone = true;
				this.saveEdits();
			},

		    applyTextEdit: function (text) {
				this.animal.narrative = text
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
             * Get list of available gender values
             */
            getGenders() {
                window.axios.get('/api/genders')
                    .then(response => {
                        this.genderList = response.data;
                    });
            },

            /**
             * Get a list of breeds
             */
            getBreeds() {
            	if (!this.animal.species) this.animal.species = "Dog";
                window.axios.get('/api/breeds', {params: { species: this.animal.species }})
                    .then(response => {
                        this.breedList = response.data;
                    });
            },

            initAnimal() {
	        	var today = new Date().toISOString().substr(0,10);

                this.$set(this.animal,'id', 0);
                this.$set(this.animal,'species', "Dog");
                this.$set(this.animal,'is_va_releasing_agency', false);
                this.$set(this.animal,'foster', "");
                this.$set(this.animal,'pri_breed', "");
                this.$set(this.animal,'sec_breed', "");
                this.$set(this.animal,'mix', true);
                this.$set(this.animal,'color', "");
                this.$set(this.animal,'date_of_birth', today);
                this.$set(this.animal,'intake_date', today);
                this.$set(this.animal,'sex', "");
                this.$set(this.animal,'altered', false);
                this.$set(this.animal,'origin', "");
                this.$set(this.animal,'origin_id', "");
                this.$set(this.animal,'name', "");
                this.$set(this.animal,'image_file', "comingsoon.jpg");
                this.$set(this.animal,'narrative', "");
                this.$set(this.animal,'rescue_groups_id', 0);
                this.$set(this.animal,'status', "Available");
                this.$set(this.animal,'status_date', today);
                this.$set(this.animal,'tagnum', "");
                this.$set(this.animal,'weight', 0);
            },

            /**
             * Get single animal
             */
            getSelectedAnimal() {
            	this.initAnimal();
            	if(this.animalId > 0) {
	                window.axios.get('/api/animals/' + this.animalId)
	                    .then(response => {
	                   		this.animal = Object.assign({}, this.animal, response.data);
                            if (this.isClone) {
								this.animalId = 0;
								this.animal.id = 0;
								this.animal.name = "";
	                        	this.animal.rescue_groups_id = response.data.rescue_groups_id || 0;
							}
	                	});
		        } 
            }
		}
    }
</script>
