<?php

namespace Vain\Presenters\Menu;

use Knp\Menu\ItemInterface;

class BackendPresenter extends VainPresenter
{
    /**
     * @param ItemInterface $item
     * @param array         $options
     */
    protected function renderRootElement(ItemInterface $item, array $options = [])
    {
        $class = explode(' ', $item->getChildrenAttribute('class', ''));
        $class[] = 'sidebar-menu';

        $item->setChildrenAttribute('class', implode(' ', $class)); // add base class
    }

    /**
     * @param ItemInterface $item
     * @param array         $options
     *
     * @return string
     */
    protected function renderItem(ItemInterface $item, array $options)
    {
        // if we don't have access or this item is marked to not be shown
        if (!$item->isDisplayed()) {
            return '';
        }

        // create an array than can be imploded as a class list
        $class = (array) $item->getAttribute('class');
        if ($item->getLevel() === 1) {
            $class[] = 'treeview';
        }

        if ($this->matcher->isCurrent($item)
            || $this->matcher->isAncestor($item, $options['matchingDepth'])
        ) {
            $class[] = $options['currentClass'];
        }

        // retrieve the attributes and put the final class string back on it
        $attributes = $item->getAttributes();
        if (!empty($class)) {
            $attributes['class'] = implode(' ', $class);
        }

        // opening li tag
        $html = $this->format(
            '<li'.$this->renderHtmlAttributes($attributes).'>',
            'li',
            $item->getLevel(),
            $options
        );

        // render the text/link inside the li tag
        //$html .= $this->format($item->getUri() ? $item->renderLink() : $item->renderLabel(), 'link', $item->getLevel());
        $html .= $this->renderLink($item, $options);

        // renders the embedded ul
        $childrenClass = (array) $item->getChildrenAttribute('class');
        $childrenClass[] = 'treeview-menu';

        $childrenAttributes = $item->getChildrenAttributes();
        $childrenAttributes['class'] = implode(' ', $childrenClass);

        $html .= $this->renderList($item, $childrenAttributes, $options);

        // closing li tag
        $html .= $this->format('</li>', 'li', $item->getLevel(), $options);

        return $html;
    }

    /**
     * @param ItemInterface $item
     * @param array         $options
     *
     * @return string
     */
    protected function renderLinkElement(ItemInterface $item, array $options)
    {
        return sprintf('<a href="%s"%s>%s<span>%s</span>%s</a>',
            $this->escape($item->getUri()),
            $this->renderHtmlAttributes($item->getLinkAttributes()),
            $this->renderIcon($item, $options),
            $this->renderLabel($item, $options),
            $this->renderFolding($item, $options));
    }

    /**
     * @param ItemInterface $item
     * @param array         $options
     *
     * @return string
     */
    protected function renderSpanElement(ItemInterface $item, array $options)
    {
        return sprintf('<span%s>%s<span>%s</span>%s</span>',
            $this->renderHtmlAttributes($item->getLabelAttributes()),
            $this->renderIcon($item, $options),
            $this->renderLabel($item, $options),
            $this->renderFolding($item, $options));
    }

    /**
     * @param ItemInterface $item
     * @param array         $options
     *
     * @return string
     */
    protected function renderIconElement(ItemInterface $item, array $options = [])
    {
        return sprintf('<i class="fa fa-%s"></i>', $item->getExtra('icon'));
    }

    /**
     * @param ItemInterface $item
     * @param array         $options
     *
     * @return string
     */
    protected function renderFoldingElement(ItemInterface $item, array $options = [])
    {
        return '<i class="fa fa-angle-left pull-right"></i>';
    }
}
