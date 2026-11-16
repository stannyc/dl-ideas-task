<div class="col-md-6">
	<div class="card card-primary card-outline mb-4">
		<form>
			<div class="card-body">
				<div class="mb-3">
					<label for="nameInput" class="form-label">Product Name</label>
					<input type="text" class="form-control" id="nameInput" />
				</div>
				<div class="mb-3">
					<label for="descriptionInput" class="form-label">Description</label>
					<!-- <input type="password" class="form-control" id="descriptionInput" /> -->
					 <textarea class="form-control" id="descriptionInput"></textarea>
				</div>
				<div class="mb-3">
					<label for="inputGroupFile02" class="form-label">Price</label>
					<div class="input-group mb-3">
						<span class="input-group-text">$</span>
						<input
							type="text"
							class="form-control"
							aria-label="Amount (to the nearest dollar)" />
						<span class="input-group-text">.00</span>
					</div>
				</div>
				<div class="mb-3">
					<label for="inputGroupFile02" class="form-label">Product Image</label>
					<input type="file" class="form-control" id="inputGroupFile02" />					
				</div>
			</div>
			<div class="card-footer d-flex justify-content-end gap-2">
				<button type="reset" class="btn btn-danger px-4">Reset</button>
				<button type="submit" class="btn btn-primary px-4">Save</button>
			</div>
		</form>
	</div>
</div>
