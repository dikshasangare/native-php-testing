<div class="bg-white border-b border-gray-100">  
    <native:top-bar title="" subtitle="">
        <native:top-bar-action
            id="search"
            label="Search"
            icon="search"
            url="https://yourapp.com/my-account"
        />
    </native:top-bar>

    <native:side-nav gestures-enabled="true">
        <native:side-nav-header
            title="My App"
            subtitle="user@example.com"
            icon="person"
        />

        <native:side-nav-item
            id="home"
            label="Home"
            icon="home"
            url="/"
            :active="true"
        />

        <native:side-nav-group heading="Account" :expanded="false">
            <native:side-nav-item
                id="profile"
                label="Profile"
                icon="person"
                url="/profile"
            />
            <native:side-nav-item
                id="settings"
                label="Settings"
                icon="settings"
                url="/settings"
            />
        </native:side-nav-group>

        <native:horizontal-divider />

        <native:side-nav-item
            id="help"
            label="Help"
            icon="help"
            url="https://help.example.com"
            open-in-browser="true"
        />
    </native:side-nav>
</div>