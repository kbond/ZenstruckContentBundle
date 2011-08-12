# Information

This Bundle uses Doctrine2's Class Table Inheritance
(see http://www.doctrine-project.org/docs/orm/2.1/en/reference/inheritance-mapping.html#class-table-inheritance)
for more information.  The problem with Doctrine2's implementation is it requires
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

    **Note**: They can also extend eachother (``Node->Page->BlogPost``)

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

To provide your own templates set the ``default_template`` option in your ``config.yml``:

        zenstruck_content:
            default_template: YourApplicationBundle:Content:node.html.twig

**Note:** the default template name must be ``node``.

## Full Default Configuration

    zenstruck_content:
        use_controller: false
        use_form: false
        default_template: ZenstruckContentBundle:Node:node.html.twig
        node_class:  Zenstruck\Bundle\ContentBundle\Entity\Node # required
        content_types: {}

# TODO

* Advanced implementation using nested set extension



