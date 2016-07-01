<?php

/**
 * Represent A node in the tree
 *
 * Class Node
 */
class Node
{
    /**
     * @var Represent the value of the node
     */
    private $value;

    /**
     * @var Node A link to the parent node
     */
    private $parent;

    /**
     * @var Node|null Left child
     */
    private $left;

    /**
     * @var Node|null Right child
     */
    private $right;

    public function __construct($value, Node $parent = null)
    {
        $this->value = $value;
        $this->parent = $parent;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getLeft()
    {
        return $this->left;
    }

    public function setLeft($left)
    {
        $this->left = $left;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function setRight($right)
    {
        $this->right = $right;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function isLeaf()
    {
        return is_null($this->left) && is_null($this->right);
    }
}


/***
 * Solving Maximum path sum I (Problem 18)
 * @url https://projecteuler.net/problem=18
 *
 * I think the information can be modeled using a left balanced binary tree.
 *
 * Class BTree
 */
class BTree
{
    /**
     * @var Node the first node in the tree
     */
    private $root;

    /**
     * @var Node Track the current node allow easy insertion of new node in the tree.
     */
    private $current;

    public function __construct()
    {
        $this->root = null;
    }

    /**
     * This function allows to stop adding node in the left branch and start adding it in the right branch of the root
     * node.
     * @return $this
     */
    public function resetCurrent()
    {
        $this->current = $this->root;

        // For fluent interface purpose
        return $this;
    }

    /**
     * Add a new node in the tree.
     *
     * @param $value the value of the node
     * @param bool $isLeaf
     * @return $this
     */
    public function add($value, $isLeaf = false)
    {
        // Create root node
        if (is_null($this->root)) {
            $this->root = new Node($value);
            $this->current = $this->root;

            return $this;
        }

        $node = new Node($value, $this->current);

        // The left branch has priority
        if (is_null($this->current->getLeft())) {
            $this->current->setLeft($node);
        } elseif (is_null($this->current->getRight())) {
            $this->current->setRight($node);
        }

        // Advance current node
        if (!$isLeaf) {
            $this->current = $node;
        }

        // If all node in the left branch has been filled then bubble up the current node to the top of the tree
        while (!is_null($this->current->getLeft()) && !is_null($this->current->getRight())) {
            $this->current = $this->current->getParent();
        }

        // For fluent interface purpose
        return $this;
    }

    /**
     * Find the max in the tree
     *
     * @param null|Node $node Represent a node in the ree
     * @return int
     */
    private function maxRoute($node)
    {
        // Leaf Node
        if (is_null($node)) {
            return 0;
        } elseif (is_null($node->getLeft())) {
            return $node->getValue() + $this->maxRoute($node->getRight());
        } elseif (is_null($node->getRight())) {
            return $node->getValue() + $this->maxRoute($node->getLeft());
        } elseif ($node->getLeft()->getValue() > $node->getRight()->getValue()) {
            return $node->getValue() + $this->maxRoute($node->getLeft());
        } else {
            return $node->getValue() + $this->maxRoute($node->getRight());
        }
    }

    /**
     * Allows to find the route that follows @method BTree::max() in the tree to determine max value
     *
     * @param $node
     * @return string The followed route
     */
    private function path($node)
    {
        // Leaf Node
        if (is_null($node)) {
            return 0;
        } elseif (is_null($node->getLeft())) {
            return $node->getValue() . '/' . $this->path($node->getRight());
        } elseif (is_null($node->getRight())) {
            return $node->getValue() . '/' . $this->path($node->getLeft());
        } elseif ($node->getLeft()->getValue() > $node->getRight()->getValue()) {
            return $node->getValue() . '/' . $this->path($node->getLeft());
        } else {
            return $node->getValue() . '/' . $this->path($node->getRight());
        }
    }

    public function max()
    {
        return $this->maxRoute($this->root);
    }

    public function route()
    {
        return $this->path($this->root);
    }
}


/**
 * For testing purpose
 *
 * @comments Tested on PHP 5.5.9
 * Class Test
 */
class Test
{
    public static function generateTree()
    {
        // 23
        $max = (new BTree())
            ->add(3)
            ->add(7)
            ->add(2)
            ->add(8, true)
            ->add(5, true)
            ->add(4)
            ->add(9, true)
            ->add(3, true)
            ->add(4)
            ->add(6, true)
            ->max();

        print_r($max . PHP_EOL);

        /**
         *  This is a subset representation of the big tringule
         *
         *               75
         *            /     \
         *           95      64
         *          /   \     /
         *         17   47    82
         *        / \   /     /
         *       18 35 87     10
         *      /  \   / \    /
         *    20    4 82  47 65
         *   / \     / \  / \
         * 19   1   23 75 3  34
         *
         *
         */
        $tree = (new BTree())
            ->add(75)
            ->add(95)
            ->add(17)
            ->add(18)
            ->add(20)
            ->add(19, true) // Leaf
            ->add(1, true) // Leaf
            ->add(4, true) // Leaf
            ->add(35, true) // Leaf
            ->add(47)
            ->add(87)
            ->add(82)
            ->add(23, true)  // Leaf
            ->add(75, true) // Leaf
            ->add(47)
            ->add(3, true)  // Leaf
            ->add(34, true) // Leaf
            ->resetCurrent()
            ->add(64)
            ->add(82)
            ->add(10)
            ->add(65);

        print_r($tree->max() . PHP_EOL);
        print_r($tree->route() . PHP_EOL);
    }
}

Test::generateTree();
