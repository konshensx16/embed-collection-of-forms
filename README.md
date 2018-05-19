Embed Collection Of Forms
========================

Here's a link to a youtube video explaining this repository:
https://youtu.be/nLy7dIQPCUI

Check the timestamps in the description

What this repository contains
--------------

* Configuring your symfony application to  use SQLite instead of Mysql
* Creating Two entities: User and Exp (means Experience) which are related with the following relationship:
    * Exp.php
        * @ORM\ManyToOne(targetEntity="User", inversedBy="exp")
         * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    * User.php:
        * @ORM\OneToMany(targetEntity="Exp", mappedBy="user", cascade={"persist"})
        * Also don't forget to set the user in addExp function:
            ```
            public function addExp(\AppBundle\Entity\Exp $exp)
              {
                  $this->exp[] = $exp;
                  // setting the current user to the $exp,
                  // adapt this to whatever you are trying to achieve
                  $exp->setUser($this);
                  return $this;
              }
            ```
* Next up, creating the forms from the command-line, pretty straight forward
    * ExpType.php:
        * Nothing special about this file
    * User.php:
        ```
       public function buildForm(FormBuilderInterface $builder, array $options)
           {
               $builder
                   ->add('fullname')
                   // this is the embeded form, the most important things are highlighted at the bottom
                   ->add('exp', CollectionType::class, [
                       'entry_type' => ExpType::class,
                       'entry_options' => [
                           'label' => false
                       ],
                       'by_reference' => false,
                       // this allows the creation of new forms and the prototype too
                       'allow_add' => true,
                       // self explanatory, this one allows the form to be removed
                       'allow_delete' => true
                   ])
                   // just a regular save button to persist the changes
                   ->add('save', SubmitType::class, [
                       'attr' => [
                           'class' => 'btn btn-success'
                       ]
                   ])
               ;
           }
        ```
* Next, sending the form to the view and hadling the form submition
* Creating the JavaScript file which does most of the work:
    * Please look up the file in the repository, i cannot put the code here because it's about 80 or 90 lines long
* And finally persisting the data to the database