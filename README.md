# Information

This Bundle allows for various *content-types* using Doctrine2's Inheritance
(see http://www.doctrine-project.org/docs/orm/2.1/en/reference/inheritance-mapping.html
for more information).  It allows for all your content-types to inherit from a single ``Node``.
The problem with Doctrine2's implementation is it requires
you set all your inherited Entities in the top most Entity.  With this Bundle
they are setup in your ``config.yml``.

# Configuration

1. Create a ``Node`` class:

        // path/to/your/bundle/Entity/Node.php

        namespace YourApplicationBundle\Entity;

        use Zenstruck\Bundle\ContentBundle\Entity\Node as BaseNode;

        /**
         * @orm:Entity
         */
        class Node extends BaseNode
        {
            // add any node fields (or leave empty)
        }

2. Create one or more content-type Entities (extending from your ``Node`` entity):

        // path/to/your/bundle/Entity/BlogPost.php

        namespace YourApplicationBundle\Entity;

        /**
         * @orm:Entity
         */
        class BlogPost extends Node
        {
            /**
             * @orm:Column(type="text", nullable=true)
             */
            protected $body;

            public function getBody()
            {
                return $this->body;
            }

            public function setBody($body)
            {
                $this->body = $body;
            }
        }

    **Note**: They can also extend eachother (``BlogPost->Page->Node``)

3. Add your node class and any new content-types to your ``config.yml``:

        zenstruck_content:
                node_class: YourApplicationBundle\Entity\Node
            content_types:
                blog_post:  YourApplicationBundle\Entity\BlogPost
                ...

    **Note:** in the above example the *machine name* of class ``BlogPost`` is ``blog_post``.
    This naming convention is important.

4. (optional) To use the controller that this bundle provides activate it in your ``config.yml``:

        zenstruck_content:
            use_controller: true

5. (optional) If you used the controller in step 4, add the routing:

        zenstruck_content:
            resource: "@ZenstruckContentBundle/Resources/config/routing.xml"

# Reference

## Manager

There is a manager class that is available from the service container via the id
``zenstruck_content.manager``.

### Breadcrumbs

The manager contains a function called ``getAncestors(Node $node)``.  This returns
an array of Ancestor nodes based on the path of the current ``Node`` given.

For instance, if you pass a node with path ``foo/bar/baz`` it will return an array of nodes
with path's ``foo`` and ``foo/bar`` if they exist and in that order.

#### Usage

    // controller
    $manager = $this->container->get('zenstruck_content.manager');
    $manager->getAncestors($node);

## Inheritance Type

By default Doctrine2's *Class Table Inheritance* is used.  This means each content-type
extending from ``Node`` is it's own table linking back to the base ``node`` table.  There
is also the option of using *Class Table Inheritance*.  All content types will be
stored in the same table.

You can enable this in your ``config.yml``:

    zenstruck_content:
        inheritance_type: single_table

## Template

To provide your own templates set the ``default_template`` option in your ``config.yml``:

    zenstruck_content:
        default_template: YourApplicationBundle:Content:node.html.twig

**Note:** the default template name must be ``node``.

## InheritedUniqueEntity constraint

This bundles comes with a custom ``UniqueEntity`` validation constraint.  The default Doctrine
one has problems with inheritance.  It only checks the values of entities within it's current
scope and children.  For instance if you have this structure: ``BlogPost->Page->Node``
and place the default Doctrine ``UniqueEntity`` constraint on a field in ``Page``.  Saving a
``BlogPost`` with a field that is the same as one in ``Page`` will not cause the constraint
to become invalid.

The ``InheritedUniqueEntity`` constraint packaged with this
bundle does.

### Usage

The following demonstrates adding a UniqueEntity constraint on the ``body`` field of the ``Page``
entity.  All classes that inherit from ``Page`` will have this constraint in the ``Page`` scope.

    namespace Acme\DemoBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Zenstruck\Bundle\ContentBundle\Validator\InheritedUniqueEntity;

    /**
     * Acme\DemoBundle\Entity\Node
     *
     * @ORM\Table(name="page")
     * @ORM\Entity
     * @InheritedUniqueEntity(field="body")
     */
    class Page extends Node
    {

        /**
         * @var string $body
         *
         * @ORM\Column(name="body", type="string", length=255, nullable=true)
         */
        protected $body;

        //...
    }

## Full Default Configuration

    zenstruck_content:
        use_controller: false
        use_form: false
        inheritance_type: class_table # or single_table
        node_type_name: node
        discriminator_column: content_type # the column name
        default_template: ZenstruckContentBundle:Node:node.html.twig
        node_class:  Zenstruck\Bundle\ContentBundle\Entity\Node # required
        content_types: {}

# TODO

* Advanced implementation using nested set extension



