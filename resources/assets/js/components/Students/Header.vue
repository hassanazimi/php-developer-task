<template>
	<div class="header">
		<div style='margin: 10px 0;'>
			<input :class="['btn', selectAll ? 'btn-success' : 'btn-danger']"
			       :value="selectText"
			       @click="toggleSelection()"
			       type="button"/>
			<input @click="exportStudents()" class="btn btn-primary" type="button" value="Export Students"/>
			<input @click="exportCourseAttendance()" class="btn btn-info" type="button" value="Export Course Attendance"/>
		</div>
	</div>
</template>
<script>
	export default {
		props: ['selected'],
		data() {
			return {
				selectAll: true,
				message: 'not updated',
			};
		},
		methods: {
			toggleSelection() {
				eventBus.$emit('toggleSelection', this.selectAll);
				this.selectAll = ! this.selectAll;
			},
			exportStudents() {
				if (this.selected.length > 0) {
					swal({
						title: 'Export students',
						text: 'Are you sure you want to download the current selection?',
						type: 'info',
						showCancelButton: true,
						closeOnConfirm: false,
						showLoaderOnConfirm: true,
						cancelButtonText: 'No',
						confirmButtonText: 'Yes',
					}, () => {
						// use Axios instead of redundant Vue resources package
						axios.post('/api/export/students', {
							studentId: this.selected,
							all: false,
							api_token: Laravel.api_token, // --> we need to pass this as you use auth:api
						}).then(({ data }) => {
							/*
							here we're get a response from Csv object in the server
							because response will return a csv string and because
							it's asyn response, i created a methid called save
							that will download the response into a csv blob
							it gets the data which is returned from the server
							and file name as string and it will try to save it
							*/
							this.save(data, 'students.csv');
							swal.close();
						}, (response) => {
							sweetAlert('Oops...', 'We are terribly sorry, but there it was an error downloading your selection, please try again', 'error');
						});
					});

				} else {
					sweetAlert('Oops...', 'You need to select some students in order to export them', 'error');
				}
			},
			exportCourseAttendance() {
				swal({
					title: 'Export course attendance',
					text: 'Are you sure you want to download the current selection?',
					type: 'info',
					showCancelButton: true,
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
					cancelButtonText: 'No',
					confirmButtonText: 'Yes',
				}, () => {
					// use Axios instead of redundant Vue resources package
					axios.post('/api/export/course-attendance', { api_token: Laravel.api_token })
					     .then(({ data }) => {
						     this.save(data, 'courses.csv');
						     swal.close();
					     }, (response) => {
						     sweetAlert('Oops...', 'We are terribly sorry, but there it was an error downloading your selection, please try again', 'error');
					     });
				});
			},
			/**
			 * Saves the response into a file.
			 *
			 * @param data
			 * @param fileName
			 */
			save(data, fileName) {
				// create an actual link to mock a download link
				const a = document.createElement('a');
				// append to the body
				document.body.appendChild(a);
				// hide it
				a.style    = 'display: none';
				// create a new Blob with the specified type
				const blob = new Blob([data], { type: 'octet/stream' });
				// create a URL from the blob
				const url  = window.URL.createObjectURL(blob);
				// assign href to the URL and click on it
				a.href     = url;
				a.download = fileName;
				a.click();
				// revoke object url after downloading it
				window.URL.revokeObjectURL(url);
			},
		},
		computed: {
			selectText() {
				return this.selectAll ? 'Select all' : 'Unselect all';
			},
		},
	};
</script>
