<?php namespace Pyro\MenusModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Assignment\Table\AssignmentTableBuilder;
use Anomaly\Streams\Platform\Field\Form\FieldFormBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Pyro\MenusModule\Assignment\AssignmentObserver;
use Pyro\MenusModule\Link\LinkModel;

/**
 * Class FieldsController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class FieldsController extends AdminController
{

    /**
     * Return an index of existing fields.
     *
     * @param AssignmentTableBuilder $table
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(AssignmentTableBuilder $table, LinkModel $model)
    {
        AssignmentModel::observe(AssignmentObserver::class);

        return $table
            ->setOption('sortable', true)
            ->setStream($model->getStream())
            ->render();
    }

    /**
     * Choose a field type for creating a field.
     *
     * @param FieldTypeCollection $fieldTypes
     *
     * @return \Illuminate\View\View
     */
    public function choose(FieldTypeCollection $fieldTypes)
    {
        return $this->view->make('pyro.module.menus::admin/fields/choose', [ 'field_types' => $fieldTypes ]);
    }

    /**
     * Return the form for a new field.
     *
     * @param FieldFormBuilder    $form
     * @param LinkModel           $model
     * @param FieldTypeCollection $fieldTypes
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(FieldFormBuilder $form, LinkModel $model, FieldTypeCollection $fieldTypes)
    {
        $form
            ->setStream($model->getStream())
            ->setOption('auto_assign', true)
            ->setFieldType($fieldTypes->get($this->request->get('field_type')));

        return $form->render();
    }

    /**
     * Return a form to edit the field.
     *
     * @param AssignmentRepositoryInterface               $assignments
     * @param FieldFormBuilder                            $form
     * @param LinkModel                                   $model
     * @param                                             $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(AssignmentRepositoryInterface $assignments, FieldFormBuilder $form, LinkModel $model, $id)
    {
        /* @var AssignmentInterface $assignment */
        $assignment = $assignments->find($id);

        return $form
            ->setStream($model->getStream())
            ->render($assignment->getFieldId());
    }
}
