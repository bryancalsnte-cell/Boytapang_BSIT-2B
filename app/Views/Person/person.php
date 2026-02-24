<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Manage Persons</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Persons</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

 <div class="modal fade" id="editPersonModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="editPersonForm">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Person</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="date" name="birthday" id="editBirthday" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Persons</h3>
              <div class="float-right">
                <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#addPersonModal">
                  <i class="fa fa-plus-circle fa fw"></i> Add New Person
                </button>
              </div>
            </div>
            <div class="card-body">
               <table id="personTable" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php if(!empty($person)): ?>
                        <?php foreach($person as $row): ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['name']) ?></td>
                                <td><?= esc($row['birthday']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning edit-person" data-id="<?= $row['id'] ?>">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-person" data-id="<?= $row['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="addPersonModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="addPersonForm">
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-plus-circle fa fw"></i> Add New Person</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>ID</label>
                <input type="text" name="id" class="form-control" placeholder="Enter unique ID" required />
              </div>
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter full name" required />
              </div>
              <div class="form-group">
                <label>Birthday</label>
                <input type="date" name="birthday" class="form-control" required />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
             <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script> const baseUrl = "<?= base_url() ?>"; </script>
<script src="<?= base_url('js/person.js') ?>"></script>
<?= $this->endSection() ?>