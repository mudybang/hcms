<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">

            <?php if(!empty(session()->getFlashdata('message'))) : ?>

            <div class="alert alert-success">
                <?php echo session()->getFlashdata('message');?>
            </div>
                
            <?php endif ?>

            <a href="<?php echo base_url('post/new') ?>" class="btn btn-md btn-success mb-3">TAMBAH DATA</a>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>TITLE</th>
                        <th>CONTENT</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $key => $list) : ?>

                        <tr>
                            <td><?php echo $list['title'] ?></td>
                            <td><?php echo $list['content'] ?></td>
                            <td class="text-center" width="140px">
                                <a href="<?php echo base_url('post/'.$list['id'].'/edit') ?>" class="btn btn-sm btn-primary" style="float:left;">EDIT</a>
                                <form action="<?php echo base_url('post/'.$list['id']) ?>" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach ?>
                </tbody>
            </table>
            <?php echo $pager->links('number', 'bootstrap_pagination') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<?= $this->endSection() ?>