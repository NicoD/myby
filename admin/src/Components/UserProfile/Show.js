import React from 'react';
import { Show, SimpleShowLayout, TextField, EditButton } from 'react-admin';

export const UserProfileShow = (props) => (
    <Show { ...props }>
        <SimpleShowLayout>
            <TextField source="@id" label="ID"/>
            <TextField source="baseDistanceMeters" label="distance"/>
            <EditButton />
        </SimpleShowLayout>
    </Show>
);
