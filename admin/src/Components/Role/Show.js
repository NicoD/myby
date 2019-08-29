import React from 'react';
import { Show, SimpleShowLayout, TextField } from 'react-admin';

export const RoleShow = (props) => (
    <Show { ...props }>
        <SimpleShowLayout>
            <TextField source="@id" label="ID"/>
            <TextField source="name" label="name"/>
        </SimpleShowLayout>
    </Show>
);
