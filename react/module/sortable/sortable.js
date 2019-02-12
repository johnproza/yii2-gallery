import {
    SortableContainer,
    SortableElement,
    arrayMove,
} from 'react-sortable-hoc';

// export const SortableItem = SortableElement(({value}) => <li>{value}</li>);

export const sortableList = SortableContainer(({items}) => {
    return (
        <ul>
            {items.map((value, index) => (
                <SortableItem key={`item-${index}`} index={index} value={value} />
            ))}
        </ul>
    );
});

