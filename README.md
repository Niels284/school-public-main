# Use this cmd to delete existing .DS_Store files
    - find . -name .DS_Store -print0 | xargs -0 git rm -f --ignore-unmatch

# Use this cmd to delete existing node_modules
    - git rm -r --cached node_modules
